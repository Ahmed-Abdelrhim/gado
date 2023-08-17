<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateProduct;
use App\Category;
use App\Product;
use App\Pro_Types;
use App\Product_Category;
use App\Product_Image;
use View;
use Image;
use File;
use Session;
use Yajra\DataTables\DataTables;

class ProductsController extends Controller
{
    public function __construct()
    {
        View::share([
            'categories'=> Category::get()
        ]);
    }

    # index
    public function Index()
    {
        $data = Product::latest()->get();
        return view('products.products',compact('data'));
    }

    # add product
    public function Add()
    {
        return view('products.add_product');
    }

    # store
    public function Store(StoreProduct $request)
    {
        $product = new Product;
        $product->name_ar        = $request->name_ar;
        $product->name_en        = $request->name_en;
        $product->des_ar         = $request->des_ar;
        $product->des_en         = $request->des_en;
        $product->price          = $request->price;
        $product->price_discount = $request->price_discount;
        $product->dealer_price   = $request->dealer_price;
        $product->stock          = $request->stock;

        # upload card image
        if(!is_null($request->card_image))
        {
            # create folder to extension if not exist
            if(!file_exists(base_path('uploads/products_images')))
            {
                mkdir(base_path('uploads/products_images'), 0777, true);
            }
            $photo=$request->card_image;
            $name = date('d-m-y').time().rand().'.'.$photo->getClientOriginalExtension();
            Image::make($photo)->save('uploads/products_images/'.$name);
            $product->image  = $name;
           
        }
        $product->save();
        # store categories
        foreach($request->categories as $category)
        {
            $cat = new Product_Category;
            $cat->category_id = $category;
            $cat->product_id  = $product->id;
            $cat->save();
        }
        if(!is_null($request->galary))
        {
            # upload galary images
            foreach($request->galary as $ga)
            {
            
                $image = new Product_Image;
                $photo=$ga;
                $name = date('d-m-y').time().rand().'.'.$photo->getClientOriginalExtension();
                Image::make($photo)->save('uploads/products_images/'.$name);
                $image->image      = $name;
                $image->product_id = $product->id;
                $image->save();
            }

        }
        # insert typpes
        $type_name_ar     = $request->type_name_ar;
        $type_name_en  = $request->type_name_en;
        $type_value_ar      = $request->type_value_ar;
        $type_value_en      = $request->type_value_en;
        $preparation = [];

        foreach ($type_name_ar as $key => $value)
        {
            $preparation[$value] = [
                'ten'  => $type_name_en[$key],
                'type_ar'      => $type_value_ar[$key],
                'type_en'      => $type_value_en[$key],
            ];
        }
        foreach($preparation as $key => $value)
        {
            $data     = json_encode($value);
            $data     = json_decode($data);

            if($key != null && $data->type_ar != null &&  $data->ten != null &&  $data->type_en != null)
            {
                $item = new Pro_Types;
                $item->name_ar    = $key;
                $item->value_ar  = $data->type_ar;
                $item->value_en  = $data->type_en;
                $item->name_en = $data->ten;
                $item->product_id  = $product->id;
                $item->save();
            }
        }


        MakeReport('بإضافة منتج '.$product->name_ar);
       Session::flash('success','تم إضافة المنتج');
       return back();
    }

    # edit
    public function Edit($id)
    {
        $data = Product::with('Images','ProTypes')->findOrFail($id);
        return view('products.edit_product',\compact('data'));
    }

    # update
    public function Update(UpdateProduct $request)
    {
        $product = Product::findOrFail($request->id);
        $product->name_ar        = $request->name_ar;
        $product->name_en        = $request->name_en;
        $product->des_ar         = $request->des_ar;
        $product->des_en         = $request->des_en;
        $product->price          = $request->price;
        $product->price_discount = $request->price_discount;
        $product->dealer_price   = $request->dealer_price;
        $product->stock          = $request->stock;
        $product->save();

        # upload card image
        if(!is_null($request->card_image))
        {
            File::delete('uploads/products_images/'.$product->image);
            $photo=$request->card_image;
            $name = date('d-m-y').time().rand().'.'.$photo->getClientOriginalExtension();
            Image::make($photo)->save('uploads/products_images/'.$name);
            $product->image  = $name;
            $product->save();
        }

        # store categories
        Product_Category::where('product_id',$product->id)->delete();
        foreach($request->categories as $category)
        {
            $cat = new Product_Category;
            $cat->category_id = $category;
            $cat->product_id  = $product->id;
            $cat->save();
        }

        # upload galary images
        if(!is_null($request->galary))
        {
            foreach($request->galary as $ga)
            {
                $image = new Product_Image;
                $photo=$ga;
                $name = date('d-m-y').time().rand().'.'.$photo->getClientOriginalExtension();
                Image::make($photo)->save('uploads/products_images/'.$name);
                $image->image      = $name;
                $image->product_id = $product->id;
                $image->save();
            }
        }

        # insert typpes
        $type_name_ar     = $request->type_name_ar;
        $type_name_en  = $request->type_name_en;
        $type_value_ar      = $request->type_value_ar;
        $type_value_en      = $request->type_value_en;
        $preparation = [];

        foreach ($type_name_ar as $key => $value)
        {
            $preparation[$value] = [
                'ten'  => $type_name_en[$key],
                'type_ar'      => $type_value_ar[$key],
                'type_en'      => $type_value_en[$key],
            ];
        }
        Pro_Types::where('product_id',$product->id)->delete();
        foreach($preparation as $key => $value)
        {
            $data     = json_encode($value);
            $data     = json_decode($data);

            if($key != null && $data->type_ar != null &&  $data->ten != null &&  $data->type_en != null)
            {
                $item = new Pro_Types;
                $item->name_ar    = $key;
                $item->value_ar  = $data->type_ar;
                $item->value_en  = $data->type_en;
                $item->name_en = $data->ten;
                $item->product_id  = $product->id;
                $item->save();
            }
        }

        MakeReport('بتحديث منتج '.$product->name_ar);
       Session::flash('success','تم تحديث المنتج');
       return back();
    }
    # delete image
    public function DeleteImage(Request $request)
    {

        $image = Product_Image::where('id',$request->id)->first();
     
        File::delete('uploads/products_images/'.$image->image);
     
        MakeReport('بحذف الصورة ');
        $image->delete();
        Session::flash('success','تم الحذف');
        return back();
    }

    # delete Product
    public function DeleteProduct($id)
    {

        $Product = Product::where('id',$id)->first();
     
        MakeReport('بحذف منتج ');
        $Product->delete();
        Session::flash('success','تم الحذف');
        return back();
    }

    public function expiredProducts()
    {
        return view('products.expired');
    }

    public function getExpiredProducts()
    {
        $products = Product::query()
            ->where('stock', '<=', '3')
            ->select('id', 'image', 'name_ar', 'price', 'dealer_price', 'stock', 'pay_count', 'created_at')
            ->orderBy('stock','asc')
            ->get();

        return Datatables::of($products)
            ->addColumn('id', function ($product) {
                return $product->id;
            })
            ->addColumn('action', function ($product) {
                $retAction = '<a href="' . route('editproducts', $product->id) . '" class="btn btn-primary btn-sm" type="submit" > <i class="fas fa-edit"></i></a>';
                $retAction .= '<a href="' . route('DeleteProduct', $product->id) . '" class="btn btn-danger btn-sm delete" type="submit" > <i class="fas fa-trash"></i></a>';
                return $retAction;
            })
            ->addColumn('image', function ($product) {
                return '<img src="' . $product->card_image . '" alt="" style="width: 100px"/>';
            })
            ->addColumn('name_ar', function ($product) {
                    return $product->name_ar;
            })
            ->addColumn('price', function ($product) {
                return $product->price;
            })
            ->addColumn('dealer_price', function ($product) {
                return $product->dealer_price;
            })
            ->addColumn('stock', function ($product) {
                return $product->stock;
            })
            ->addColumn('pay_count', function ($product) {
                return $product->pay_count;
            })
            ->addColumn('created_at', function ($product) {
                return $product->created_at;
            })
            ->rawColumns(['action'])
            ->escapeColumns([])
            ->make(true);
    }
}
