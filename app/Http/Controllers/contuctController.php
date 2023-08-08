<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contuct;

class contuctController extends Controller
{
    public function index()
    {
        $contuct = Contuct::get();
        return view('contuct.contuct',compact('contuct'));
    }

    # delete 
    public function Delete(Request $request)
    {
        $contuct = Contuct::where('id',$request->id)->first();
        Session::flash('success','تم الحذف');
        MakeReport('بحذف رسالة '.$contuct->name);
        $contuct->delete();
        return back();
    }
}
