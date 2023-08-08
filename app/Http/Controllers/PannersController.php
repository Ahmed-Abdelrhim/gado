<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pannar;
use App\Category;
use Carbon\Carbon;
use Session;
use File;
use Image;

class PannersController extends Controller
{
    # pannars page
    public function pannars()
    {
    	$pannars  = Pannar::latest()->get();

    	return view('pannars.pannars',compact('pannars'));
    }

    # add Pannar
    public function Add()
    {
        $sections = Category::with('Division')->latest()->get();
        return view('pannars.add_pannar',compact('sections'));
    }
    # store Pannar
    public function StorePannar(Request $request)
    {
        $this->validate($request,[
            'name_ar'  => 'required',
            'name_en'  => 'nullable|max:190',
            'image'    => 'nullable|mimes:jpeg,png,jpg,gif',

        ]);

        $Pannar = new Pannar;
        $Pannar->name_ar              = $request->name_ar;
        $Pannar->name_en              = $request->name_en;
        $Pannar->price_from           = $request->price_from;
        $Pannar->price_to             = $request->price_to;
        $Pannar->type                 = $request->type;
        $Pannar->kind                 = $request->kind;
        $Pannar->desc_ar              = $request->desc_ar;
        $Pannar->desc_en              = $request->desc_en;
       
        if(count($request->sections) > 0)
        {
            $sections    = json_encode($request->sections);
            $Pannar->sections= $sections;     
        }

        # upload card image
        if(!is_null($request->image))
        {
            # create folder to extension if not exist
            if(!file_exists(base_path('uploads/panners')))
            {
                mkdir(base_path('uploads/panners'), 0777, true);
            }
            $photo=$request->image;
            $name = date('d-m-y').time().rand().'.'.$photo->getClientOriginalExtension();
            Image::make($photo)->save('uploads/panners/'.$name);
            $Pannar->image  = $name;
  
        }

        $Pannar->save();

        MakeReport('بإضافة بانر جديد '.$Pannar->name_ar);
        Session::flash('success','تم حفظ البانر');
        return back();
    }

    # edit
    public function Edit($id)
    {
        $data = Pannar::findOrFail($id);
        $section     = $data->sections;
        $secs    = json_decode($section);
        $sections = Category::with('Division')->latest()->get();
        return view('pannars.edit_pannar',compact('data','sections','secs'));
    }

    # store Pannar
    public function UpdatePannar(Request $request)
    {
        $this->validate($request,[
            'name_ar'  => 'required',
            'name_en'  => 'nullable|max:190',
            'image'    => 'nullable|mimes:jpeg,png,jpg,gif',

        ]);

        $Pannar = Pannar::findOrFail($request->id);
        $Pannar->name_ar              = $request->name_ar;
        $Pannar->name_en              = $request->name_en;
        $Pannar->price_from           = $request->price_from;
        $Pannar->price_to             = $request->price_to;
        $Pannar->type                 = $request->type;
        $Pannar->kind                 = $request->kind;
        $Pannar->desc_ar              = $request->desc_ar;
        $Pannar->desc_en              = $request->desc_en;
       
        if(count($request->sections) > 0)
        {
            $sections    = json_encode($request->sections);
            $Pannar->sections= $sections;     
        }

        # upload card image
        if(!is_null($request->image))
        {
            File::delete('uploads/panners/'.$Pannar->image);
            $photo=$request->image;
            $name = date('d-m-y').time().rand().'.'.$photo->getClientOriginalExtension();
            Image::make($photo)->save('uploads/panners/'.$name);
            $Pannar->image  = $name;
        }
        $Pannar->save();

        MakeReport('بتحديث بانر '.$Pannar->name_ar);
        Session::flash('success','تم حفظ التعديلات');
        return back();
    }

    # delete Pannar
    public function DeletePannar($id)
    {
    	$Pannar = Pannar::findOrFail($id);
        MakeReport('بحذف بانر '.$Pannar->name_ar);
    	$Pannar->delete();
        Session::flash('success','تم حذف البانر');
        return back();
    }
}
