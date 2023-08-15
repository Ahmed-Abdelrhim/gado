<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dealer;
use Session;
use Image;
use File;

class DealersController extends Controller
{
    # index
    public function Index()
    {
        $data = Dealer::query()
            ->where('phone', '!=', 'null')
            // ->latest()
            ->orderBy('id', 'desc')
            ->get();
        return view('dealers.dealers', ['data' => $data]);
    }

    # edit
    public function Edit($id)
    {
        $data = Dealer::where('id', $id)->with('Orders')->first();
        return view('dealers.edit_dealer', compact('data'));
    }

    # update
    public function Update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:dealers,email,' . $request->id,
            'phone' => 'nullable|unique:dealers,phone,' . $request->id,
            'commercial_registration_num' => 'nullable|unique:dealers,commercial_registration_num,' . $request->id,
            'tax_card_num' => 'nullable|unique:dealers,tax_card_num,' . $request->id,
            'active' => 'required',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        $data = Dealer::where('id', $request->id)->first();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->active = $request->active;
        $data->commercial_registration_num = $request->commercial_registration_num;
        $data->tax_card_num = $request->tax_card_num;

        # password
        if (!is_null($request->password)) {
            $data->password = bcrypt($request->password);
        }

        # upload avatar
        if (!is_null($request->avatar)) {
            # delete avatar
            if ($data->avatar != 'default.png') {
                File::delete('uploads/dealers/avatar/' . $data->avatar);
            }

            # upload new avatar
            $photo = $request->avatar;
            $name = date('d-m-y') . time() . rand() . '.' . $photo->getClientOriginalExtension();
            Image::make($photo)->save('uploads/dealers/avatar/' . $name);
            $data->avatar = $name;
        }

        $data->save();
        MakeReport('بتحديث تاجر ' . $data->name);
        Session::flash('success', 'تم الحفظ');
        return redirect()->route('dealers');
    }

    # delete
    public function Delete($id)
    {
        $data = Dealer::where('id', $id)->first();
        if ($data->avatar != 'default.png') {
            File::delete('uploads/dealers/avatar/' . $data->avatar);
        }
        MakeReport('بحذف تاجر ' . $data->name);
        $data->delete();
        Session::flash('success', 'تم الحذف');
        return back();
    }
}
