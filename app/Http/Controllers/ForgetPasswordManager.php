<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Str;

class ForgetPasswordManager extends Controller
{
    function forgetPassword(){
        return view("forget-password");
    }

    function forgetPasswordPost(Request $request){
        $request->validate([
            'email' => "required|email|exists:users",
        ]);
        $token = Str::random(64);
    }
}
