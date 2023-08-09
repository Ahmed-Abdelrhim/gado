<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Session;
use Image;
use File;

class CustomersController extends Controller
{
    # index
    public function Index()
    {
        $data = Customer::query()->where('phone','!=','null')->latest()->get();
        return view('customers.customers',compact('data'));
    }

    # edit
    public function Edit($id)
    {
        $data = Customer::where('id',$id)->with('Orders')->first();
    	return view('customers.edit_customer',compact('data'));
    }

    # update
    public function Update(Request $request)
    {
        $this->validate($request,[
            'name'      => 'required',
            'email'     => 'required|unique:customers,email,'.$request->id,
            'phone'     => 'nullable|unique:customers,phone,'.$request->id,
            'active'    => 'required',
            'avatar'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        $data = Customer::where('id',$request->id)->first();
        $data->name     = $request->name;
        $data->email    = $request->email;
        $data->phone    = $request->phone;
        $data->active   = $request->active;

        # password
        if(!is_null($request->password))
        {
            $data->password = bcrypt($request->password);
        }

        # upload avatar
        if(!is_null($request->avatar))
        {
        	# delete avatar
	    	if($data->avatar != 'default.png')
	    	{
	   			File::delete('uploads/customers/avatar/'.$data->avatar);
	    	}

	    	# upload new avatar
            $photo=$request->avatar;
            $name =date('d-m-y').time().rand().'.'.$photo->getClientOriginalExtension();
            Image::make($photo)->save('uploads/customers/avatar/'.$name);
            $data->avatar=$name;
        }

        $data->save();
        MakeReport('بتحديث عميل ' .$data->name);
        Session::flash('success','تم الحفظ');
        return redirect()->route('customers');
    }

    # delete
    public function Delete($id)
    {
        $data = Customer::where('id',$id)->first();
    	if($data->avatar != 'default.png')
    	{
   			File::delete('uploads/customers/avatar/'.$data->avatar);
    	}
    	MakeReport('بحذف عميل '.$data->name);
    	$data->delete();
    	Session::flash('success','تم الحذف');
    	return back();
    }	
}
