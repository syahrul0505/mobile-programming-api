<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Biliard;
use App\Models\MeetingRoom;
use App\Models\MenuPackages;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OtherSetting;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;
class ApiController extends Controller
{
    public function getApiBiliard()
    {
        $meeting_room = Biliard::orderBy('id', 'ASC')->get()->map(function($item){
            $data['id'] = $item->id;
            $data['nama'] = $item->nama;
            $data['no_meja'] = $item->no_meja;
            $data['harga'] = $item->harga;
            $data['status'] = $item->status;
            $data['image'] = asset('assets/images/biliard/' . ($item->image ?? 'no-pictures.png'));
            $data['description'] = $item->description;
            $data['slug'] = $item->slug;
            return $data;
        });

        return response()->json($meeting_room);
    }

    public function getRolesUser()
    {
        // $user = User::orderBy('id', 'ASC')->where()->get();

        $user = User::whereHas('roles', function ($query) {
            $query->where('name', 'Barista')->orWhere('name', 'Server / Waiters');;
        })->orderBy('id', 'ASC')->get();

        return response()->json($user);
    }

    public function getApiMeetingRoom()
    {
        $meeting_room = MeetingRoom::orderBy('id', 'ASC')->get()->map(function($item){
            $data['id'] = $item->id;
            $data['nama'] = $item->nama;
            $data['no_meja'] = $item->no_meja;
            $data['harga'] = $item->harga;
            $data['status'] = $item->status;
            $data['image'] = asset('assets/images/meeting-room/' . ($item->image ?? 'no-pictures.png'));
            $data['description'] = $item->description;
            $data['slug'] = $item->slug;
            return $data;
        });

        return response()->json($meeting_room);
    }

    public function getApiDetail($type, $slug){
        try {
            if ($type == 'resto') $getData = Restaurant::where('slug', $slug)->orderBy('id', 'ASC')->limit(1)->get()->map(function($item){
                $data['id'] = $item->id;
                $data['nama'] = $item->nama;
                $data['harga'] = $item->harga;
                $data['_diskonharga'] = $item->harga_diskon;
                $data['image'] = asset('assets/images/restaurant/'.($item->image ?? 'no-pictures.png'));
                $data['description'] = $item->description;
                $data['slug'] = $item->slug;
                $data['stok_perhari'] = $item->stok_perhari;
                $data['type'] = strtoupper('MENU '. $item->category);
                return $data;
            });

            if ($type == 'billiard') $getData = Biliard::where('slug', $slug)->orderBy('id', 'ASC')->limit(1)->get()->map(function($item){
                $data['id'] = $item->id;
                $data['nama'] = $item->nama;
                $data['harga'] = $item->harga;
                $data['har_diskonga'] = $item->harga_diskon;
                $data['image'] = asset('assets/images/biliard/'.($item->image ?? 'no-pictures.png'));
                $data['description'] = $item->description;
                $data['slug'] = $item->slug;
                $data['type'] = 'MEJA BILLIARD';
                return $data;
            });

            if ($type == 'meetingroom') $getData = MeetingRoom::where('slug', $slug)->orderBy('id', 'ASC')->limit(1)->get()->map(function($item){
                $data['id'] = $item->id;
                $data['nama'] = $item->nama;
                $data['harga'] = $item->harga;
                $data['harga_diskon'] = $item->harga_diskon;
                $data['image'] = asset('assets/images/meeting-room/'.($item->image ?? 'no-pictures.png'));
                $data['description'] = $item->description;
                $data['slug'] = $item->slug;
                $data['type'] = 'MEETING ROOM';
                return $data;
            });

            $json = [
                "success" => true,
                "message"=> "Berhasil get data!",
                "code"=> 200,
                "data" => $getData
            ];
            return $json;
        } catch (\Throwable $th) {
            $json = [
                "success" => false,
                "message"=> "Failed get data!, ". $th->getMessage(),
                "code"=> 500,
                "data" => []
            ];
            return $json;
        }
    }

    public function getApiBanner()
    {
        // $image = Storage::get($path);
        $banner = Banner::orderBy('id', 'ASC')->get()->map(function($item){
            $data['id'] = $item->id;
            $data['image'] = asset('assets/images/banner/' . ($item->image ?? 'no-pictures.png'));
            return $data;
        });

        return response()->json($banner);

    }
    public function getApiResto()
    {
        // $image = Storage::get($path);
        $product = Product::orderBy('id', 'ASC')->get()->map(function($item){
            $data['id'] = $item->id;
            $data['name'] = $item->name;
            $data['category'] = $item->category_id ?? '-';
            $data['purchase_price'] = $item->purchase_price;
            $data['selling_price'] = $item->selling_price;
            $data['status'] = $item->status;
            $data['current_stock'] = $item->current_stock;
            $data['image'] = asset('assets/images/product/' . ($item->image ?? 'no-pictures.png'));
            $data['description'] = $item->description;
            $data['slug'] = $item->slug;
            return $data;
        });

        return response()->json($product);
    }

    public function getApiCategory()
    {
        // $image = Storage::get($path);
        $product = Tag::orderBy('id', 'ASC')->get()->map(function($item){
            $data['id'] = $item->id;
            $data['name'] = $item->tag_name;
            return $data;
        });

        return response()->json($product);
    }
    

    public function checkout(Request $request)
    {
        // Buat order
        $order = Order::create([
            'user_id' => 1,
            'name' => 'Syahrul',
            'phone' => '089629600054',
            'qty' => $request->qty,
            'sub_total' => $request->sub_total,
            'total_price' => $request->total_price,
            'status_pembayaran' => 'Paid',
            'status_pesanan' => 'process',
            'created_at' => now(),
        ]);

        // Buat order detail untuk setiap item
        foreach ($request->items as $item) {
            $order_detail = new OrderDetail();
            $order_detail->order_id = $order->id;
            $order_detail->name = $item['name'];
            $order_detail->qty = $item['quantity'];
            $order_detail->price_discount = $item['price_discount'];
            $order_detail->save();
        }

        return response()->json(['message' => 'Order created successfully', 'order' => $order]);
    }

    public function detailTransaksi()
    {
        $orders = Order::with('orderDetails')->orderBy('id', 'ASC')->get()->map(function($item){
            $data['id'] = $item->id;
            $data['name'] = $item->name;
            $data['phone'] = $item->phone ?? '-';
            $data['qty'] = $item->qty;
            $data['status_pembayaran'] = $item->status_pembayaran;

            // Menambahkan order details
            $data['order_details'] = $item->orderDetails->map(function($detail) {
                return [
                    'id' => $detail->id,
                    'product_id' => $detail->product_id,
                    'name' => $detail->name,
                    'category' => $detail->category,
                    'qty' => $detail->qty,
                    'price_discount' => $detail->price_discount,
                    'price' => $detail->price,
                    'status_pesanan' => $detail->status_pesanan,
                ];
            });

            return $data;
        });

        return response()->json($orders);
    }



    public function postCart()
    {
        $data ['other_setting'] = OtherSetting::get()->first();

        if (Auth::check()) {
            # code...
            $data['data_carts'] = \Cart::session(Auth::user()->id)->getContent();
        }else{
            $user = 'guest';
            $data['cart_guest'] = \Cart::session($user)->getContent();
        }
        // dd($data['data_carts'][0]['attributes']);
        $processedCartItems = [];

        if (Auth::check()) {
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
            return response()->json($data);
        }else{
            foreach ($data['cart_guest'] as $cartItem) {
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
            return response()->json($data);
        }


    }

    public function getApiUser()
    {
        // $image = Storage::get($path);
        $product = User::orderBy('id', 'ASC')->get()->map(function($item){
            $data['id'] = $item->id;
            $data['name'] = $item->name;
            $data['email'] = $item->email;
            $data['password'] = $item->password;
            return $data;
        });

        return response()->json($product);
    }

    public function getApiPaketMenu()
    {
        // $image = Storage::get($path);
        $banner = MenuPackages::orderBy('id', 'ASC')->get()->map(function($item){
            $data['id'] = $item->id;
            $data['nama_paket'] = $item->nama_paket;
            $data['category'] = $item->category;
            $data['billiard_id'] = $item->billiard_id;
            $data['harga'] = $item->harga;
            $data['harga_diskon'] = $item->harga_diskon;
            $data['persentase'] = $item->persentase;
            $data['status'] = $item->status;
            $data['image'] = asset('assets/images/paket-menu/' . ($item->image ?? 'no-pictures.png'));
            $data['description'] = $item->description;
            $data['slug'] = $item->slug;
            $data['status_konfirmasi'] = $item->status_konfirmasi;
            return $data;
        });

        return response()->json($banner);
    }
}
