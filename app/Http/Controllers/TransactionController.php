<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartHeader;
use App\Models\CartDetail;
use App\Models\TrHeader;
use App\Models\TrDetail;
use App\Models\MsProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function viewProducts(){
        $products = DB::table('ms_products')
                        ->join('ms_product_types', 'ms_products.product_type_id', '=', 'ms_product_types.id')
                        ->select('ms_products.id', 'ms_products.product_type_id', 'ms_product_types.producttype',
                        'ms_products.name', 'ms_products.description', 'ms_products.price', 'ms_products.stock',
                        'ms_products.imagepath')
                        ->simplePaginate(5);

        $user = Session::get('usersession', "default");

        $header = DB::table('cart_headers')
                    ->join('cart_details', 'cart_headers.id', '=', 'cart_details.cart_header_id')
                    ->select('cart_details.product_id')
                    ->where('cart_headers.user_id', '=', $user["id"])->get();

        return view("viewProduct", ['products' => $products, 'header' => $header]);
    }

    public function viewProductsbyName(Request $req){
        $products = DB::table('ms_products')
                        ->join('ms_product_types', 'ms_products.product_type_id', '=', 'ms_product_types.id')
                        ->select('ms_products.id', 'ms_products.product_type_id', 'ms_product_types.producttype',
                        'ms_products.name', 'ms_products.description', 'ms_products.price', 'ms_products.stock',
                        'ms_products.imagepath')
                        ->where('name', 'like', $req->search . "%")
                        ->simplePaginate(5);

        $user = Session::get('usersession', "default");

        $header = DB::table('cart_headers')
                        ->join('cart_details', 'cart_headers.id', '=', 'cart_details.cart_header_id')
                        ->select('cart_details.product_id')
                        ->where('cart_headers.user_id', '=', $user["id"])->get();

        return view("viewProduct", ['products' => $products, 'header' => $header]);
    }

    public function viewCart(){
        $user = Session::get('usersession', "default");

        $carts = DB::table('cart_headers')
                    ->join('cart_details', 'cart_headers.id', '=', 'cart_details.cart_header_id')
                    ->join('ms_products', 'cart_details.product_id', '=', 'ms_products.id')
                    ->select('ms_products.stock', 'ms_products.name', 'cart_details.id', 
                    'cart_details.quantity', 'ms_products.imagepath', 'ms_products.price')
                    ->where('cart_headers.user_id', '=', $user["id"])->get();

        $total = DB::table('cart_headers')
                    ->join('cart_details', 'cart_headers.id', '=', 'cart_details.cart_header_id')
                    ->join('ms_products', 'cart_details.product_id', '=', 'ms_products.id')
                    ->select(DB::raw("SUM(ms_products.price*cart_details.quantity) as total"))
                    ->where('cart_headers.user_id', '=', $user["id"])->get();

        $status = DB::table('cart_headers')
                    ->select("status")
                    ->where('user_id', '=', $user["id"])->get();

        return view("viewCart", ['carts' => $carts, 'total' => $total[0]->total, 'status' => $status]);
    }

    public function addToCart(Request $req){
        $user = Session::get('usersession', "default");

        $header = DB::table('cart_headers')
                    ->select('cart_headers.id', 'cart_headers.user_id')
                    ->where('user_id', '=', $user["id"]);

        if(!$header->first()){
            $cartHeader = new CartHeader();
            $cartHeader->user_id = $user["id"];
            $cartHeader->status = "Not Finalized";
            $cartHeader->timestamps = false;
            $cartHeader->save();

            $header = DB::table('cart_headers')
                ->select('cart_headers.id', 'cart_headers.user_id')
                ->where('user_id', '=', $user["id"]);
        }

        $cartDetail = new CartDetail();
        $cartDetail->cart_header_id = $header->first()->id;
        $cartDetail->product_id = $req->id;
        $cartDetail->quantity = $req->quantity;
        $cartDetail->timestamps = false;

        $cartDetail->save();

        return response()->json("Success");
    }

    public function editItemInCart(Request $req){
        $cart = CartDetail::find($req->id);

        $cart->quantity = $req->quantity != null ? $req->quantity : $cart->quantity;
        $cart->timestamps = false;

        $cart->save();

        return response()->json("success");
    }

    public function removeFromCart(Request $req){
        $cart = CartDetail::find($req->id);

        if(isset($cart)){
            $cart -> delete();

            return response()->json("success");
        }

        return response()->json("failed");
    }

    public function finalizeCart(Request $req){
        $user = Session::get('usersession', "default");

        $cartId = DB::table('cart_headers')
                    ->select('id')
                    ->where('user_id', '=', $user["id"])->get();

        $cart = CartHeader::find($cartId[0]->id);

        $cart->status = "Finalized";
        $cart->timestamps = false;

        $cart->save();

        return response()->json("success");
    }

    public function viewCheckout(){
        $headers = DB::table('cart_headers')
                    ->join('ms_users', 'cart_headers.user_id', '=', 'ms_users.id')
                    ->select('cart_headers.id', 'ms_users.fullname')
                    ->where('cart_headers.status', '=', "Finalized")
                    ->simplePaginate(5);

        $totals = DB::table('cart_headers')
                    ->join('cart_details', 'cart_headers.id', '=', 'cart_details.cart_header_id')
                    ->join('ms_products', 'cart_details.product_id', '=', 'ms_products.id')
                    ->select(DB::raw("SUM(ms_products.price*cart_details.quantity) as total"))
                    ->groupby('cart_headers.id')
                    ->where('cart_headers.status', '=', "Finalized")->get();

        return view("checkout", ['headers' => $headers, 'totals' => $totals]);
    }

    public function viewCheckoutDetail($id){
        $id = Crypt::decryptString($id);

        $details = DB::table('cart_details')
                    ->join('ms_products', 'cart_details.product_id', '=', 'ms_products.id')
                    ->select('ms_products.name', 'ms_products.imagepath', 'cart_details.quantity', 'ms_products.price')
                    ->where('cart_details.cart_header_id', '=', $id)->get();

        $total = DB::table('cart_details')
                    ->join('ms_products', 'cart_details.product_id', '=', 'ms_products.id')
                    ->select(DB::raw("SUM(ms_products.price*cart_details.quantity) as total"))
                    ->where('cart_details.cart_header_id', '=', $id)->get();

        return view('checkoutDetail', ['headerId' => $id, 'details' => $details, 'total' => $total[0]->total]);
    }

    public function checkoutTransaction(Request $req){
        $user = Session::get('usersession', "default");

        $header = DB::table('cart_headers')
                    ->select()
                    ->where("id", "=", $req["headerId"])->get();

        if($header[0]->id){
            $TrHeader = new TrHeader();
            $TrHeader->user_id = $header[0]->user_id;
            $TrHeader->staff_id = $user["id"];
            $TrHeader->user_id = $header[0]->user_id;
            
            $currTime = Carbon::now();
            $currTime->setTimezone('Asia/Jakarta');

            $TrHeader->transaction_date = $currTime->toDateTimeString();

            $TrHeader->timestamps = false;
            $TrHeader->save();

            $TrHeader = DB::table('tr_headers')
            ->select('id')
            ->where('user_id', '=', $header[0]->user_id)
            ->where('transaction_date', '=', $currTime->toDateTimeString())->get();
        }

        $details = DB::table('cart_details')
        ->select('id', 'cart_header_id', 'product_id', 'quantity')
        ->where('cart_header_id', '=', $header[0]->id)->get();

        if($details[0]->id){
            foreach($details as $detail){
                $TrDetail = new TrDetail();
                $TrDetail->header_transaction_id = $TrHeader[0]->id;
                $TrDetail->product_id = $detail->product_id;
                $TrDetail->quantity = $detail->quantity;
    
                $TrDetail->timestamps = false;
                $TrDetail->save();

                $product = MsProduct::find($detail->product_id);
                $product->stock = $product->stock-$detail->quantity;
                $product->timestamps = false;
                $product->save();
            }
        }

        DB::table('cart_details')->where('cart_header_id', $header[0]->id)->delete();

        $header = CartHeader::find($req["headerId"]);
        $header->status = "Not Finalized";
        $header->timestamps = false;

        $header->save();

        return response()->json("success");
    }

    public function viewHistoryCheckout(){
        $user = Session::get('usersession', "default");

        $headers = DB::table('tr_headers')
                    ->join('ms_users', 'tr_headers.user_id', '=', 'ms_users.id')
                    ->select('tr_headers.id', 'tr_headers.transaction_date', 'ms_users.fullname as customerName')
                    ->where('tr_headers.staff_id', '=', $user["id"])
                    ->simplePaginate(5);

        $totals = DB::table('tr_headers')
                    ->join('tr_details', 'tr_headers.id', '=', 'tr_details.header_transaction_id')
                    ->join('ms_products', 'tr_details.product_id', '=', 'ms_products.id')
                    ->select(DB::raw("SUM(ms_products.price*tr_details.quantity) as total"))
                    ->groupby('tr_headers.id')
                    ->where('tr_headers.staff_id', '=', $user["id"])->get();

        return view("historyCheckout", ['headers' => $headers, 'totals' => $totals]);
    }

    public function viewHistoryCheckoutDetail($id)
    {
        $id = Crypt::decryptString($id);

        $details = DB::table('tr_details')
                    ->join('ms_products', 'tr_details.product_id', '=', 'ms_products.id')
                    ->select('ms_products.name', 'ms_products.imagepath', 'tr_details.quantity', 'ms_products.price')
                    ->where('tr_details.header_transaction_id', '=', $id)->get();

        $total = DB::table('tr_details')
                    ->join('ms_products', 'tr_details.product_id', '=', 'ms_products.id')
                    ->select(DB::raw("SUM(ms_products.price*tr_details.quantity) as total"))
                    ->where('tr_details.header_transaction_id', '=', $id)->get();

        return view('historyCheckoutDetail', ['details' => $details, 'total' => $total[0]->total]);
    }

    public function viewHistoryTransaction(){
        $user = Session::get('usersession', "default");

        $headers = DB::table('tr_headers')
                    ->join('ms_users as a', 'tr_headers.user_id', '=', 'a.id')
                    ->join('ms_users as b', 'tr_headers.staff_id', '=', 'b.id')
                    ->select('tr_headers.id', 'tr_headers.transaction_date', 
                    'a.fullname as fullname', 'b.fullname as staff')
                    ->where('tr_headers.user_id', '=', $user["id"])
                    ->simplePaginate(5);

        $totals = DB::table('tr_headers')
                    ->join('tr_details', 'tr_headers.id', '=', 'tr_details.header_transaction_id')
                    ->join('ms_products', 'tr_details.product_id', '=', 'ms_products.id')
                    ->select(DB::raw("SUM(ms_products.price*tr_details.quantity) as total"))
                    ->groupby('tr_headers.id')
                    ->where('tr_headers.user_id', '=', $user["id"])->get();

        return view("historyTransaction", ['headers' => $headers, 'totals' => $totals]);
    }

    public function viewHistoryTransactionDetail($id)
    {
        $id = Crypt::decryptString($id);

        $details = DB::table('tr_details')
                    ->join('ms_products', 'tr_details.product_id', '=', 'ms_products.id')
                    ->select('ms_products.name', 'ms_products.imagepath', 'tr_details.quantity', 'ms_products.price')
                    ->where('tr_details.header_transaction_id', '=', $id)->get();

        $total = DB::table('tr_details')
                    ->join('ms_products', 'tr_details.product_id', '=', 'ms_products.id')
                    ->select(DB::raw("SUM(ms_products.price*tr_details.quantity) as total"))
                    ->where('tr_details.header_transaction_id', '=', $id)->get();

        return view('historyTransactionDetail', ['details' => $details, 'total' => $total[0]->total]);
    }
}
