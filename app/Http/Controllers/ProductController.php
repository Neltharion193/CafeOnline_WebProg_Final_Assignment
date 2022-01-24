<?php

namespace App\Http\Controllers;

use App\Models\MsProduct;
use App\Models\MsProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function viewManageProduct(){
        $types = MsProductType::all();

        $products = DB::table('ms_products')
                        ->join('ms_product_types', 'ms_products.product_type_id', '=', 'ms_product_types.id')
                        ->select('ms_products.id', 'ms_products.product_type_id', 'ms_product_types.producttype',
                        'ms_products.name', 'ms_products.description', 'ms_products.price', 'ms_products.stock',
                        'ms_products.imagepath')
                        ->simplePaginate(5);

        return view("manageProduct", ['types' => $types, 'products' => $products]);
    }

    public function viewManageProductbyName(Request $req){
        $types = MsProductType::all();

        $products = DB::table('ms_products')
                        ->join('ms_product_types', 'ms_products.product_type_id', '=', 'ms_product_types.id')
                        ->select('ms_products.id', 'ms_products.product_type_id', 'ms_product_types.producttype',
                        'ms_products.name', 'ms_products.description', 'ms_products.price', 'ms_products.stock',
                        'ms_products.imagepath')
                        ->where('name', 'like', $req->search . "%")
                        ->simplePaginate(5);

        return view("manageProduct", ['types' => $types, 'products' => $products]);
    }

    public function createProduct(Request $req){
        $file = $req->file('product_image');
        $imageName = time() . '.' . $file->getClientOriginalExtension();
        Storage::putFileAs('public/images', $file, $imageName);
        $imagePath = 'images/' . $imageName;

        $product = new MsProduct();
        $product->product_type_id = $req->type;
        $product->name = $req->name;
        $product->price = $req->price;
        $product->stock = $req->stock;
        $product->description = $req->description;
        $product->imagepath = $imagePath;
        $product->timestamps = false;

        $product->save();

        return response()->json("success");
    }

    public function editProduct(Request $req){
        $product = MsProduct::find($req->id);

        $file = $req->file('product_image');

        $product->product_type_id = $req->type != null ? $req->type : $product->product_type_id;
        $product->name = $req->name != null ? $req->name : $product->name;
        $product->price = $req->price != null ? $req->price : $product->price;
        $product->stock = $req->stock != null ? $req->stock : $product->stock;
        $product->description = $req->description != null ? $req->description : $product->description;
        $product->timestamps = false;

        if($file != null){
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs('public/images', $file, $imageName);
            $imagePath = 'images/' . $imageName;

            Storage::delete('/public' . $product->imagepath);
            $product->imagepath = $imagePath;
        }

        else{
            $req->product_image = $product->imagepath;
        }

        $product->save();

        return response()->json("success");
    }

    public function deleteProduct(Request $req){
        $product = MsProduct::find($req->id);

        if(isset($product)){
            Storage::delete('public/' . $product->imagepath);

            $product -> delete();

            return response()->json("success");
        }

        return response()->json("failed");
    }
}
