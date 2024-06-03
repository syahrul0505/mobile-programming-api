<?php

namespace App\Http\Controllers;

use App\Models\AddOnDetail;
use App\Models\OtherSetting;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class CartOrderController extends Controller
{
    public function index()
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
            return view('cart.index',$data);    
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
            return view('cart.cart-guest',$data);
        }

    }

    public function addCartRestaurant(Request $request,$id)
    {
        // dd($request->all());

        try {
            $restaurant = Restaurant::findOrFail($id);
        
        if ($restaurant->current_stock <= 0) {
            return redirect()->back()->with(['failed' => 'Stok ' . $restaurant->name . ' Kurang!']);
        }

        $currentTime = Carbon::now()->format('H:i');

        $other_setting = OtherSetting::get()->first();

        $currentDay = date('N'); // Mendapatkan hari dalam format 1 (Senin) hingga 7 (Minggu)
        if ($restaurant->category == 'Minuman' && $restaurant->category == 'Makanan') {
            
            if ($currentDay >= 1 && $currentDay <= 4) {
                // Weekdays (Senin-Kamis)
                $orderOpenTimeMakanan = $other_setting->time_start;
                $orderDeadlineMakanan = $other_setting->time_close;
            } else if ($currentDay >= 5 && $currentDay <= 7) {
                // Weekend (Sabtu/Minggu)
                // dd('masuk');
                $orderOpenTimeMakanan = $other_setting->time_start_weekend;
                $orderDeadlineMakanan = $other_setting->time_close_weekend;
            }
            if ($currentTime > $orderDeadlineMakanan) {
                return redirect()->back()->with(['failed' => 'Maaf, Kita Sudah Close Order']);
            } elseif ($currentTime < $orderOpenTimeMakanan) {
                // Jika waktu saat ini masih sebelum batas pemesanan pagi, maka tampilkan pesan bahwa pemesanan belum dibuka
                return redirect()->back()->with(['failed' => 'Maaf, Cafe belum dibuka. Silakan coba lagi nanti']);
            }
        }
        
        

        $dataHargaAddon = [];
        if ($request->harga_add != null) {
            foreach ($request->harga_add as $key => $val) {
                $data_addOn = AddOnDetail::where('id', $val)->get();
                $dataHargaAddon[] = $data_addOn[0]->harga . '';
            }
        }



        $countAddOn = $request->harga_add ? count($request->harga_add) : 0;

        if ((($countAddOn < $request->minimum) && $restaurant->addOns->isNotEmpty()) && $request->addOnChange != 'Normal') {
            return redirect()->back()->with(['failed' => 'Harap Pilih Add On Sesuai minimum !!']);
        }

        if ($request->quantity) {
            $quantity = $request->quantity;
        } else {
            $quantity = 0;
        }
    
        
        // dd($dataHargaAddon);
        $validator = Validator::make($request->all(), [
            'qty' => 'nullable',
            'category' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Auth::check()) {
            $cartContent = \Cart::session(Auth::user()->id)->getContent();
            
            $addonDetail = array(
                'restaurant' => $restaurant,
                'harga_add' => $dataHargaAddon,
                'add_nama' => $request->add_nama,
                'modal_resto' => $request->modal_detail,
                'description' => $request->description,
            );
        
            $itemIdentifier = md5(json_encode($addonDetail));
            
            // Cek apakah item yang akan ditambahkan sudah ada di keranjang
            $existingItem = $cartContent->first(function ($item, $key) use ($itemIdentifier) {
                $attributes = $item->attributes;
        
                // Sesuaikan dengan atribut yang digunakan untuk identifikasi
                return $attributes['restaurant'] === $itemIdentifier && $attributes['description'] === $request->description;
            });
            
            if ($existingItem !== null) {
                // Jika item sudah ada, tambahkan jumlahnya
                $existingItem->quantity += $request->quantity;
                \Cart::session(Auth::user()->id)->update($existingItem->id, [
                    'quantity' => $existingItem->quantity,
                ]);
            } else {
                // Jika item belum ada, tambahkan item baru ke keranjang
                if ($restaurant->price_discount == 0) {
                    $price = $restaurant->price;
                } else {
                    $price = $restaurant->price_discount;
                }
        
                \Cart::session(Auth::user()->id)->add(array(
                    'id' => $itemIdentifier, // Gunakan identifikasi yang unik untuk setiap produk
                    'name' => $restaurant->name,
                    'price' => $price,
                    'quantity' => $request->quantity,
                    'attributes' => $addonDetail,
                    'conditions' => 'Restaurant',
                    'associatedModel' => Restaurant::class
                ));
            }
            
            $category = $request->category;
            return redirect()->route('shop.index')->with('success', 'Berhasil masuk cart!');
        } else {
            // dd('tes');
            $user = 'guest';
            // \Cart::session($user)->add(array(
            //     'id' => $restaurant->id, // inique row ID
            //     'name' => $restaurant->nama,
            //     'price' => ($restaurant->harga_diskon + (is_array($dataHargaAddon) ? array_sum($dataHargaAddon) : 0) ?? $restaurant->harga_diskon),
            //     'quantity' => $request->qty,
            //     // 'attributes' => array($restaurant),
            //     'attributes' => array(
            //         'restaurant' => $restaurant,
            //         'category' => $request->category,
            //         'add_on_title' => $request->add_on_title,
            //         // 'harga_add' => array_sum($dataHargaAddon),
            //         'harga_add' => $dataHargaAddon,
            //         'detail_addon_id' => $request->harga_add,
            //     ),
            //     'conditions' => 'Restaurant',
            //     'associatedModel' => Restaurant::class
           
            // ));

            // return redirect()->back()->with('failed', 'Silahkan Tanya Waiters');

            // Mengambil konten Cart berdasarkan user ID
            $cartContent = \Cart::session($user)->getContent();
        
            // Membuat array dari add-on detail untuk digunakan sebagai kunci unik
            $addonDetail = array(
                'restaurant' => $restaurant,
                'category' => $request->category,
                'add_on_title' => $request->add_on_title,
                'harga_add' => $dataHargaAddon,
                'detail_addon_id' => $request->harga_add,
                'add_on_nama_title' => $request->add_on_nama_title,
                'add_nama' => $request->add_nama,
            );
        
            // Mengkonversi array add-on detail menjadi JSON untuk digunakan sebagai kunci unik
            $itemIdentifier = md5(json_encode($addonDetail));
        
            // Memeriksa apakah item dengan add-on detail yang sama sudah ada di dalam Cart
            $existingItem = $cartContent->first(function ($item, $key) use ($itemIdentifier) {
                return $item->id === $itemIdentifier;
            });
        
            // kode lama
            if ($existingItem !== null) {
                // Jika item dengan add-on detail yang sama sudah ada di dalam Cart
                // Buat array baru dengan membawa detail add-on ID yang berbeda
                $itemAttributes = $existingItem->attributes->toArray();
                if (!in_array($request->harga_add, $itemAttributes['detail_addon_id'])) {
                    $itemAttributes['detail_addon_id'] = $request->harga_add;
                    $existingItem->attributes = $itemAttributes;
                    $existingItem->quantity += $request->qty;
                    \Cart::session($user)->update($existingItem->id, $existingItem->toArray());
                }
            } 
            // if ($existingItem !== null) {
            //     // Jika item dengan add-on detail yang sama sudah ada di dalam Cart
            //     // Buat array baru dengan membawa detail add-on ID yang berbeda
            //     $itemAttributes = $existingItem->attributes->toArray();
                
            //     // Check if the detail_addon_id is an array
            //     if (!is_array($itemAttributes['detail_addon_id'])) {
            //         $itemAttributes['detail_addon_id'] = []; // Initialize as an array
            //     }
            
            //     if (!in_array($request->harga_add, $itemAttributes['detail_addon_id'])) {
            //         $itemAttributes['detail_addon_id'][] = $request->harga_add;
            //         $existingItem->attributes = $itemAttributes;
            //         $existingItem->quantity += $request->qty;
            //         \Cart::session($user)->update($existingItem->id, $existingItem->toArray());
            //     }
            // }
                else {
                // Jika item dengan add-on detail tertentu belum ada di dalam Cart, tambahkan data cart baru
                \Cart::session($user)->add(array(
                    'id' => $itemIdentifier, // Gunakan kunci unik sebagai ID item
                    'name' => $restaurant->nama,
                    'price' => ($restaurant->harga_diskon + (is_array($dataHargaAddon) ? array_sum($dataHargaAddon) : 0) ?? $restaurant->harga_diskon),
                    'quantity' => $request->qty,
                    'attributes' => $addonDetail,
                    'conditions' => 'Restaurant',
                    'associatedModel' => Restaurant::class
                ));
            }
            
            $category = $request->category;
            return redirect()->route('shop.index', ['category' => $category])->with('success', 'Berhasil Masuk Cart !');
        }
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', $th->getMessage());
        }
        
    }

    public function updateCart(Request $request)
    {
        // dd($request->id);
        // $totalPrice = $request->qty * $price;
        // update the item on cart
        // \Cart::session(Auth::user()->id)->add($request->id,[
        //     'quantity' => $request->qty,
        //     // 'price' => $totalPrice
        // ]);
        // update the item on cart
        // \Cart::session(Auth::user()->id)->update($request->id,[
        //     'quantity' => $request->qty,
        // ]);
        // Cart::update($request->id, array(
        //     'quantity' => $request->qty, // so if the current product has a quantity of 4, another 2 will be added so this will result to 6
        // ));
        // OrderPivot::create([
        //     'restaurant_id' => $request->id,
        //     'qty' => $request->qty,
        // ]);
                // item cart diupdate sesuai dengan qty yang diinput
        \Cart::session(Auth::user()->id)->update($request->id, [
            'quantity' => array(
                'relative' => false,
                'value' => $request->qty
            ),
        ]);

    }

    public function updateCartGuest(Request $request)
    {
        $user = auth()->guest() ? 'guest' : auth()->user()->id;
        \Cart::session($user)->update($request->id, [
            'quantity' => [
                'relative' => false,
                'value' => $request->qty
            ],
        ]);

        return response()->json(['success' => true]);

        // if($request->id && $request->quantity){
        //     $cart = session()->get('cart');
        //     $cart[$request->id]["quantity"] = $request->quantity;
        //     session()->put('cart', $cart);
        //     session()->flash('success', 'Cart successfully updated!');
        // }
    }



    public function deleteCartRestaurant($id)
    {
        if (Auth::check()) {
            # code...
            \Cart::session(Auth::user()->id)->remove($id);
        }
        $user = 'guest';
        \Cart::session($user)->remove($id);
        return redirect()->back();
    }

}
