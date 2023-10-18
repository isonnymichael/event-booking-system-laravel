<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function doLogin(Request $request)
    {
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        if(!Auth::Attempt($data)){
            Session::flash('error', 'Email or Password wrong !');

            return redirect('/');
        }else{
            return redirect("/dashboard");
        }
    }

    public function doLogout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function doRegister(Request $request)
    {
        $user = User::where('email','=', $request->input("email"))->first();

        if($user!=null){
            Session::flash('error', 'Account already Exists!!');
            return redirect('/');
        }

        $user = User::create([
            'name' => $request->input("name"),
            'email' => $request->input("email"),
            'password' => Hash::make($request->input("password")),
            'role' => 'user',
        ]);

        $login = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];
        Auth::Attempt($login);

        return redirect('/dashboard');
    }

    public function allUsers()
    {
        $breadcrumbs = [
            [
                "title" => "Dashboard",
                "link" => "/dashboard"
            ],
            [
                "title" => "All Users",
                "link" => ""
            ]
        ];

        $users = DB::table("users")->whereNot("role","=","admin")->get();

        return response()
            ->view("dashboard.users",[
                "title" => "All Users",
                "breadcrumbs" => $breadcrumbs,
                "users" => $users
            ]);
    }

    public function profile(Request $request)
    {
        $breadcrumbs = [
            [
                "title" => "Dashboard",
                "link" => "/dashboard"
            ],
            [
                "title" => "Profile",
                "link" => ""
            ]
        ];

        if(Auth::user()->role == "admin"){
            $user = DB::table("users")->where("id","=",$request->input("id"))->first();
            if(!$user){
                Session::flash('error', 'User not found!');
                return redirect('/');
            }
        }else{
            $id = $request->input("id");
            if(isset($id) && ($id != Auth::user()->id)){
                Session::flash('error', 'Cannot access this page!');
                return redirect('/');
            }

            $user = DB::table("users")->where("id","=",Auth::user()->id)->first();
        }

        return response()
            ->view("dashboard.profile",[
                "title" => "Profile",
                "breadcrumbs" => $breadcrumbs,
                "user" => $user
            ]);
    }

    public function updateProfile(Request $request)
    {
        $datas = request()->except(['_token','id','files','oldPassword','newPassword']);

        $user = DB::table("users")->where("id","=",$request->input("id"))->first();
        if(!$user){
            Session::flash('error', 'User not found!');
            return back();
        }

        $oldPasswordCorrect = false;
        if(Hash::check($request->input("oldPassword"),$user->password)){
            $oldPasswordCorrect = true;
        }
        if(!$oldPasswordCorrect){
            Session::flash('error', 'Password is Wrong!');
            return back();
        }

        if(Auth::user()->role == "user"){
            if($request->input("id") != Auth::user()->id){
                Session::flash('error', 'Cannot access this page!');
                return back();
            }
        }

        $datas['updated_at'] = Carbon::now();
        $datas['password'] = Hash::make($request->input("newPassword"));

        $result = DB::table("users")->where("id","=",$request->input("id"))->update($datas);

        if(!$result){
            Session::flash('error', 'Failed update profile');
        }

        Session::flash('status', 'Success update profile');
        return back();
    }
}
