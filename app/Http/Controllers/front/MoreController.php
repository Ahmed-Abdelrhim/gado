<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MoreController extends Controller
{
    public function TermsAndConditions()
    {
        return view('front.more.terms_an_conditions');
    }
}
