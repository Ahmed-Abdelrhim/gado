<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Email;

class emailController extends Controller
{
    public function index()
    {
        $Email = Email::get();
        return view('contuct.Email',compact('Email'));
    }

}
