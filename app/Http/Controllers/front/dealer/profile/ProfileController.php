<?php

namespace App\Http\Controllers\front\dealer\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Dealer;
use App\Division;
use Session;
use Hash;

class ProfileController extends Controller
{
    # index
    public function Index()
    {
        // $data = Division::where('id',1)->with('Categories')->latest()->first();
        $div = "1";
       return view('front.profile.dealer.profile',compact('div'));
    }

    # update
    public function Update(Request $request)
    {
        $this->validate($request,[
            'name'     => 'required|min:10|max:50',
            'email'    => 'nullable|min:5|email|max:190|unique:dealers,email,'.auth()->guard('dealer')->user()->id,
            'phone'    => 'nullable|unique:dealers,phone,'.auth()->guard('dealer')->user()->id,
        ]);

       $data = Dealer::where('id',auth()->guard('dealer')->user()->id)->first();
       $data->name  = $request->name;
       $data->email = $request->email;
       $data->save();
        Session::flash('success','تم الحفظ');
        return back();
    }

    # update password
    public function UpdatePassword(Request $request)
    {
        $this->validate($request,[
            'old_password'   => 'required|min:6|max:190',
            'password'       => 'required|confirmed|min:6|max:190',
        ]);
        $data = Dealer::where('id',auth()->guard('dealer')->user()->id)->first();

        if(Hash::check($request->old_password,$data->password))
        {
            $data->password = bcrypt($request->password);
            $data->save();
            Session::flash('success','تم الحفظ');
            return back();
        }else{
            Session::flash('danger','كلمة المرور القديمة غير صحيحة');
            return back();
        }
    }
}
