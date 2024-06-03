<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OtherSetting;
use App\Models\Restaurant;
use App\Models\RestaurantAddOn;
use App\Models\RestaurantTag;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request){
        return redirect()->back()->with(['failed' => 'Izin Terlebih Dahulu Ke Admin!']);

        $data ['restaurants'] = Restaurant::get();
        $data['tags'] = Tag::get();
        $data['discounts'] = Discount::get();
        $data ['other_setting'] = OtherSetting::get()->first();
        $data['orders'] = Order::whereDate('created_at', Carbon::today())
                ->where('status_pembayaran', 'Paid')
                ->orderBy('invoice_no', 'desc')
                ->get();

        $data['add_ons'] = AddOn::get();
        $data['restaurant_tags'] = RestaurantTag::where("restaurant_id",$request->id)
        ->pluck('tag_id')
        ->all();

        $data['restaurant_add_on'] = RestaurantAddOn::where("restaurant_id",$request->id)
        ->pluck('add_on_id')
        ->all();
        if (Auth::check()) {
            # code...
            $data['data_carts'] = \Cart::session(Auth::user()->id)->getContent();
        }else{
            $user = 'guest';
            $data['cart_guest'] = \Cart::session($user)->getContent();
        }
        // dd($data['data_carts'][0]['attributes']);
        $processedCartItems = [];

        foreach ($data['data_carts'] as $cartItem) {
            // Access individual cart item properties
            $id = $cartItem->id;
            $name = $cartItem->name;
            $price = $cartItem->price;
            $quantity = $cartItem->quantity;
            $conditions = $cartItem->conditions;

            $cartItemData = [
                'id' => $id,
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
                'conditions' => $conditions,
                // ... and so on
            ];
        }

        return view('shop.index',$data);
    }
}
