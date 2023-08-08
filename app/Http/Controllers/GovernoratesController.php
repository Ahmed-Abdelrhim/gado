<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Governorate;
use Session;

class GovernoratesController extends Controller
{
    public function Index()
    {
        $data = Governorate::latest()->get();
        return view('governorates.governorates',compact('data'));
    }

    # store
    public function Store(Request $request)
    {
        $this->validate($request,[
            'name_ar'      => 'required',
            'name_en'      => 'nullable|max:190',
            'shipping_fee'  => 'required',
        ]);


        $data = new Governorate;
        $data->name_ar     = $request->name_ar;
        $data->name_en  = $request->name_en;
        $data->shipping_fee = $request->shipping_fee;

        $data->save();
    
        Session::flash('success','تم الحفظ');
        MakeReport('بإضافة محافظه جديد'.$data->name_ar);
        return back();
    }

    # update
    public function Update(Request $request)
    {
        $this->validate($request,[
            'edit_name_ar'      => 'required',
            'edit_name_en'      => 'nullable|max:190',
            'edit_shipping_fee'  => 'required',

        ]);

        $data = Governorate::where('id',$request->edit_id)->first();
        $data->name_ar     = $request->edit_name_ar;
        $data->name_en     = $request->edit_name_en;
        $data->shipping_fee = $request->edit_shipping_fee;
     

        $data->save();
        Session::flash('success','تم الحفظ');
        MakeReport('بتحديث محافظة '.$data->name_ar);
        return back();
    }

    # delete
    public function Delete($id)
    {
        $data = Governorate::where('id',$id)->first();
        MakeReport('بحذف محافظه '.$data->name_ar);
        $data->delete();
        Session::flash('success','تم الحذف');
        return back();
    }
}
