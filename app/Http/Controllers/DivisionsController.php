<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Division;
use Session;
use File;
use Image;

class DivisionsController extends Controller
{
    public function Index()
    {
        $data = Division::latest()->get();
        return view('divisions.divisions',compact('data'));
    }

    # store
    public function Store(Request $request)
    {
        $this->validate($request,[
            'name_ar'  => 'required',
            'name_en'  => 'nullable|max:190',
            'image'    => 'nullable|mimes:jpeg,png,jpg,gif',
        ]);

        $data = new Division;
        $data->name_ar = $request->name_ar;
        $data->name_en = $request->name_en;

        # create folder if not exist
        if(!file_exists(base_path('uploads/divisions_images')))
        {
            mkdir(base_path('uploads/divisions_images'), 0777, true);
        }
        $photo=$request->image;
        $name = date('d-m-y').time().rand().'.'.$photo->getClientOriginalExtension();
        Image::make($photo)->save('uploads/divisions_images/'.$name);
        $data->image      = $name;

        $data->save();
        Session::flash('success','تم الحفظ');
        MakeReport('بإضافة فئة جديدة'.$data->name_ar);
        return back();
    }

    # update
    public function Update(Request $request)
    {
        $this->validate($request,[
            'edit_name_ar'  => 'required',
            'edit_name_en'  => 'nullable|max:190',
            'edit_image'    => 'nullable|mimes:jpeg,png,jpg,gif',

        ]);

        $data = Division::where('id',$request->edit_id)->first();
        $data->name_ar = $request->edit_name_ar;
        $data->name_en = $request->edit_name_en;

        if(!is_null($request->edit_image))
        {
            File::delete('uploads/divisions_images/'.$data->image);
            $photo=$request->edit_image;
            $name = date('d-m-y').time().rand().'.'.$photo->getClientOriginalExtension();
            Image::make($photo)->save('uploads/divisions_images/'.$name);
            $data->image      = $name;
        }

        $data->save();
        Session::flash('success','تم الحفظ');
        MakeReport('بتحديث فئة '.$data->name_ar);
        return back();
    }

    # delete
    public function Delete($id)
    {
        $data = Division::where('id',$id)->first();
        File::delete('uploads/divisions_images/'.$data->image);
        MakeReport('بحذف فئة '.$data->name_ar);
        $data->delete();
        Session::flash('success','تم الحذف');
        return back();
    }
}
