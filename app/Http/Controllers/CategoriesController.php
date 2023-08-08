<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Division;
use Session;
use Image;
use File;

class CategoriesController extends Controller
{
    public function Index()
    {
        $data = Category::with('Division')->latest()->get();
        $divisions = Division::latest()->get();
        return view('categories.categories',compact('data','divisions'));
    }

    # store
    public function Store(Request $request)
    {
        $this->validate($request,[
            'name_ar'      => 'required',
            'name_en'      => 'nullable|max:190',
            'division_id'  => 'required|max:190',
        ]);

        $data = new Category;
        $data->name_ar     = $request->name_ar;
        $data->name_en     = $request->name_en;
        $data->division_id = $request->division_id;

        if(!is_null($request->image))
        {
            $photo=$request->image;
            $name =date('d-m-y').time().rand().'.'.$photo->getClientOriginalExtension();
            Image::make($photo)->save('uploads/divisions_images/'.$name);
            $data->image =$name;
        }

        $data->save();
        Session::flash('success','تم الحفظ');
        MakeReport('بإضافة قسم جديد'.$data->name_ar);
        return back();
    }

    # update
    public function Update(Request $request)
    {
        $this->validate($request,[
            'edit_name_ar'      => 'required',
            'edit_name_en'      => 'nullable|max:190',
            'edit_division_id'  => 'required|max:190',

        ]);

        $data = Category::where('id',$request->edit_id)->first();
        $data->name_ar     = $request->edit_name_ar;
        $data->name_en     = $request->edit_name_en;
        $data->division_id = $request->edit_division_id;
        if(!is_null($request->edit_image))
        {

            File::delete('uploads/divisions_images/'.$data->image);
            $photo=$request->edit_image;
        
            $name =date('d-m-y').time().rand().'.'.$photo->getClientOriginalExtension();
            Image::make($photo)->save('uploads/divisions_images/'.$name);
            $data->image =$name;
        }

        $data->save();
        Session::flash('success','تم الحفظ');
        MakeReport('بتحديث قسم '.$data->name_ar);
        return back();
    }

    # delete
    public function Delete($id)
    {
        $data = Category::where('id',$id)->first();
        MakeReport('بحذف قسم '.$data->name_ar);
        $data->delete();
        Session::flash('success','تم الحذف');
        return back();
    }
}
