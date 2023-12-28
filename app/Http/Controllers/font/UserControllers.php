<?php

namespace App\Http\Controllers\font;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserControllers extends Controller
{
    ////===> About Session 

    public function About()
    {
        return view('font_user.abput');
    }

    ////===> About Session 

    public function contact()
    {
        return view('font_user.contact');
    }

    ////===> Login Session 

    public function Login()
    {
        return view('font_user.login');
    }


    ////===> Login Session 
    public function singup()
    {
        return view('font_user.singup');
    }

}
