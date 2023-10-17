<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        return response()
            ->view("homepage",[
                "title" => "Homepage",
            ]);
    }
}
