<?php

namespace App\Http\Controllers;

use App\Models\User;
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
}
