<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
use App\Models\AddOnDetail;
use App\Models\Kupon;
use App\Models\Membership;
use App\Models\Order;
use App\Models\OrderAddOn;
use App\Models\OrderDetail;
use App\Models\OrderPivot;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\OtherSetting;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;


class OrderController extends Controller
{
    public function checkout(Request $request, $token)
    {

        // dd($request->modal_resto);
        try {
            $session_cart = \Cart::session(Auth::user()->id)->getContent();
            $other_setting = OtherSetting::get();

            $packing = 5000;

            $checkToken = Order::where('token',$token)->where('status_pembayaran', 'Paid')->get();
            if (count($checkToken) != 0) {
                return redirect()->route('homepage')->with(['failed' => 'Tidak dapat mengulang transaksi!']);
            }

            if ($request->metode_pembayaran == null) {
                return redirect()->back()->with(['failed' => 'Harap Pilih EDC !']);
            }

            if ($request->metode_pembayaran == "Cash") {
                if ($request->cash < \Cart::getTotal()) {
                    return redirect()->back()->with(['failed' => 'Cash Yang Dimasukan Kurang Dari Jumlah Pembelian !']);
                }
            }
            $restaurants = Restaurant::get();

            $idSessions = $request->idSession;
            $qtys = $request->qty;

            foreach ($idSessions as $key => $id) {
                $qty = $qtys[$key];

                \Cart::session(Auth::user()->id)->update($id, [
                    'quantity' => array(
                        'relative' => false,
                        'value' => $qty
                    ),
                ]);
            }

            $price = 1;

            foreach ($session_cart as $key => $value) {
                $price +=$value->price;
            }

            if (Auth::check()) {
                if ($other_setting[0]->pb01 != 0) {
                    $biaya_pb01 = \Cart::getTotal() * $other_setting[0]->pb01/100;
                    $total_price = (\Cart::getTotal()) + $biaya_pb01;
                }else{
                    $total_price = (\Cart::getTotal() ?? '0');
                }


                if ($request->total_harga == null) {
                    $total_harga = $total_price;
                }else{
                    $total_harga = $request->total_harga;
                }
                
                $service = (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100;
                $pb01 = (\Cart::getTotal()  ?? '0')  * $other_setting[0]->pb01/100;
                $name = $request->name;
                $phone = auth()->user()->telephone;
            }

            if ($request->cash == null) {
                $kembalian = 0;
                # code...
            }else{
                $kembalian = $request->cash - $total_price;
            }

            if ($request->discount == "Pilih Discount") {
                $discount = 0;
            }else{
                $discount = $request->discount;
            }
            // dd($kembalian,$total_price);
                // =======================================================  Open Bill ==================================================================================

                if ($request->bill_order) {
                    $order = Order::where('id', $request->bill_order)->first();

                    $order->user_id = auth()->user()->id;
                    $order->name = $name;
                    $order->phone = $phone;
                    $order->qty = array_sum($request->qty);
                    $order->category = $request->category;
                    $order->token = $token;
                    $order->total_price = $order->total_price + $total_harga;
                    $order->status_pembayaran = 'Paid';
                    $order->status_pesanan = 'process';
                    $order->cash = $request->cash;
                    $order->kembalian = $kembalian;
                    $order->created_at = date('Y-m-d H:i:s');
                    $order->service = $order->service + $service;
                    $order->pb01 = $order->pb01 + $pb01;
                    $order->modal = $request->modal_resto;
                    $order->persentase_pb01 = $request->persentase_pb01;
                    $order->metode_pembayaran = $request->metode_pembayaran;
                    $order->discount = $discount;

                    $order->save();

                        foreach ($session_cart as $key => $item) {
                            $orderPivot = [];
                            if ($item->conditions == 'Restaurant') {
                                if ($item->attributes['restaurant']['price_discount'] == 0) {
                                    $harga_diskon =  ($item->attributes['restaurant']['price'] ?? 0);
                                }else{
                                    $harga_diskon =  ($item->attributes['restaurant']['price_discount'] ?? 0);
                                }

                                $order_pivot = new OrderDetail();
                                $order_pivot->order_id = $request->bill_order;
                                $order_pivot->restaurant_id = $item->attributes['restaurant']['id'];
                                $order_pivot->category = $item->attributes['restaurant']['category'];
                                $order_pivot->qty = $item['quantity'];
                                $order_pivot->price_discount = $harga_diskon;
                                $order_pivot->description = $item->attributes['description'];

                                $order_pivot->save();
                            }
                        }
                }

                $order = Order::create([
                    'user_id' => auth()->user()->id,
                    'name' => $name,
                    'phone' => $phone,
                    'qty' => array_sum($request->qty),
                    'category' => $request->category,
                    'token' => $token,
                    'total_price' => $total_price,
                    'status_pembayaran' => 'Unpaid',
                    'status_pesanan' => 'process',
                    'cash' => $request->cash,
                    'kembalian' => $kembalian,
                    'created_at' => date('Y-m-d H:i:s'),
                    'service' => $service,
                    'pb01' => $pb01,
                    'modal' => $request->modal_resto,
                    'persentase_pb01' => $request->persentase_pb01,
                    'metode_pembayaran' => $request->metode_pembayaran,
                    'discount' => $discount,
                ]);
                $hargaModal = 0;
                foreach ($session_cart as $key => $item) {
                    $orderPivot = [];
                    if ($item->conditions == 'Restaurant') {
                        if ($item->attributes['restaurant']['price_discount'] == 0) {
                            $harga_diskon =  ($item->attributes['restaurant']['price'] ?? 0);
                        }else{
                            $harga_diskon =  ($item->attributes['restaurant']['price_discount'] ?? 0);
                        }

                        $order_pivot = new OrderDetail();
                        $order_pivot->order_id = $order->id;
                        $order_pivot->restaurant_id = $item->attributes['restaurant']['id'];
                        $order_pivot->category = $item->attributes['restaurant']['category'];
                        $order_pivot->qty = $item['quantity'];
                        $order_pivot->price_discount = $harga_diskon;
                        $order_pivot->modal = $item->attributes['restaurant']['modal'];
                        $order_pivot->description = $item->attributes['description'];

                        $order_pivot->save();

                    }

                    $hargaModal += ($item->attributes['modal_resto'][0] * $item->quantity);
                    $dataOrder = Order::findOrFail($order->id);
                    $dataOrder->update(['modal' => $hargaModal]);
                }
            $checkToken2 = Order::where('token',$token)->get();
            $data['token'] = $checkToken2->pluck('token');

            $tokenCart = Order::where('token', $token)->first(); // Menggunakan first() karena Anda mencari satu record
            if ($tokenCart) {
                $data['data_carts'] = \Cart::session(Auth::user()->id)->getContent();
            }
            $data['order_last'] = Order::where('token', $token)->get()->first();
            $data['other_setting'] = OtherSetting::get()->first();

            if ($tokenCart) {
                // Ubah status pembayaran menjadi "Paid"

                if ($request->bill_order) {
                    # code...
                    $tokenCart->update(['status_pembayaran' => 'Paid']);
                }else{
                    $tokenCart->update(['status_pembayaran' => 'Paid', 'invoice_no' => $this->generateInvoice()]);
                }

                $userID = $tokenCart->user_id;
                $cart = \Cart::session($userID)->getContent();

                // Menghapus item dari session cart
                foreach ($cart as $item) {
                    \Cart::session($userID)->remove($item->id);
                }

                foreach ($cart as $key => $item) {
                    $restoStock = Restaurant::where('id', $item->attributes['restaurant']['id'])->first();
                    $stockAvailable = ($restoStock->current_stock - $item['quantity']);

                    // Memperbarui stok restoran
                    $restoStock->update(['current_stock' => $stockAvailable]);
                }
            }

            if ($request->cash) {

            // Menghilangkan titik desimal dari total
            $formattedTotal = number_format($order->total_price, 0, '.', ''); // Konversi total menjadi float atau angka

            $difference = $request->cash - $formattedTotal;
                // dd($)
                return redirect()->route('shop.index')->with('cash','Uang Yang Di kembalikan '. $difference);
            }else{
                return redirect()->route('shop.index')->with('success', 'Order Telah berhasil');
            }

            // return view('checkout.index',$data,compact('order'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
            DB::rollback();
            return redirect()->back()->with('failed', $th->getMessage());
        }

    }


    public function checkoutWaiters(Request $request, $token){
        $checkToken = Order::where('token',$token)->where('status_pembayaran', 'Paid')->get()->count();
        if ($checkToken != 0) {
            return redirect()->route('homepage')->with(['failed' => 'Tidak dapat mengulang transaksi!']);
        }


        $latestOrder = Order::where('token',$token)->orderBy('id', 'desc')->first();

        // dd($latestOrder);
        if ($latestOrder) {
            // Ubah status pembayaran menjadi "Paid"
            $latestOrder->update(['status_pembayaran' => 'Paid', 'invoice_no' => $this->generateInvoice()]);

            $userID = $latestOrder->user_id;
            $cart = \Cart::session($userID)->getContent();

             // Menghapus item dari session cart
             foreach ($cart as $item) {
                \Cart::session($userID)->remove($item->id);
            }

            foreach ($cart as $key => $item) {
                $restoStock = Restaurant::where('id', $item->attributes['restaurant']['id'])->first();
                $stockAvailable = ($restoStock->current_stock - $item['quantity']);

                // Memperbarui stok restoran
                $restoStock->update(['current_stock' => $stockAvailable]);
            }

        }
        return redirect()->route('shop.index')->with('success', 'Order Telah berhasil');
    }

    public function callback(Request $request)
    {

        $serverKey =  config('midtrans.server_key');
        $hashed = hash('sha512',$request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' or $request->transaction_status == 'settlement') {
            // if ($request->transaction_status == 'settlement') {
                $order = Order::find($request->order_id);
                $paymentType = $request->payment_type;

                if ($request->transaction_status == 'settlement') {
                    $order->update(['status_pembayaran' => 'Paid', 'invoice_no' => $this->generateInvoice(), 'metode_pembayaran' => $paymentType]);
                    $orderFinishSubtotal = Order::where('user_id', $order->user_id)->where('status_pembayaran','Paid')->sum('total_price');
                    $user = User::where('id', $order->user_id)->first(); // Gunakan first() untuk mendapatkan objek user
                    $memberships = Membership::orderBy('id','asc')->get();
                    $user_member = User::where('membership_id',5)->get()->first();

                // foreach ($user_member as $key => $value) {
                    if (!$user_member) {
                        // $user->membership_id = 5;
                        // $user->save();
                        if ($user) {
                            if ($orderFinishSubtotal < $memberships[1]->minimum_transaksi) {
                                $user->membership_id = $memberships[0]->id;
                            } elseif ($orderFinishSubtotal >= $memberships[1]->minimum_transaksi && $orderFinishSubtotal < $memberships[2]->minimum_transaksi) {
                                $user->membership_id = $memberships[1]->id;
                            } elseif ($orderFinishSubtotal >= $memberships[2]->minimum_transaksi && $orderFinishSubtotal < $memberships[3]->minimum_transaksi) {
                                $user->membership_id = $memberships[2]->id;
                            } elseif ($orderFinishSubtotal >= $memberships[3]->minimum_transaksi && $orderFinishSubtotal < $memberships[4]->minimum_transaksi) {
                                $user->membership_id = $memberships[3]->id;
                            } elseif ($orderFinishSubtotal >= $memberships[4]->minimum_transaksi) {
                                $user->membership_id = $memberships[4]->id;
                            }

                            $user->save();
                        }
                    }
                }
            }
        }

    }

    public function successOrder(Request $request){

        try {
            $order = Order::find($request->data['order_id']);

            if ($order->kode_meja != null || $order->category == 'Takeaway') {

                if (auth()->guest() == true) {
                    $userUpdate = auth()->guest() ? 'guest' : auth()->user()->id;
                    $cart = \Cart::session($userUpdate)->getContent();

                    foreach ($cart as $item) {
                        \Cart::session($userUpdate)->remove($item->id);
                    }

                    foreach ($cart as $key => $item) {
                        $restoStock = Restaurant::where('id', $item->attributes['restaurant']['id'])->first();
                        $stockAvailable = ($restoStock->current_stok - $item->quantity);

                        // Memperbarui stok restoran
                        $restoStock->update(['current_stok' => $stockAvailable,]);

                    }

                    // =========================== Kupon ================================
                    if ($order->total_price >= 100000) {
                        $timestamp = time();
                        $randomSeed = $timestamp % 10000;
                        $code = str_pad(mt_rand($randomSeed, 9999), 6, '0', STR_PAD_LEFT);

                        $kupon = [
                            'order_id' => $order->id,
                            'code' => 'VMND'.$code,
                        ];

                        $totalKupon = ($order->total_price / 100000) - 1; // Hitung jumlah kupon tambahan

                        // Loop untuk membuat kupon tambahan berdasarkan kelipatan 25,000
                        $kupons = [$kupon];
                        for ($i = 1; $i <= $totalKupon; $i++) {
                            $timestamp = time();
                            $randomSeed = $timestamp % 10000;
                            $kuponCode = 'VMND2' . str_pad(mt_rand($randomSeed, 9999), 6, '0', STR_PAD_LEFT);
                            $kupons[] = [
                                'order_id' => $order->id,
                                'code' => $kuponCode
                            ];
                        }

                        // dd($kupons);
                        Kupon::insert($kupons);
                    }

                }else{
                    $userID = $order->user_id;

                    $cart = \Cart::session($userID)->getContent();

                    // Menghapus item dari session cart
                    foreach ($cart as $item) {
                        \Cart::session($userID)->remove($item->id);
                    }

                   foreach ($cart as $key => $item) {
                        $restoStock = Restaurant::where('id', $item->attributes['restaurant']['id'])->first();
                        $stockAvailable = ($restoStock->current_stok - $item['quantity']);

                        // Memperbarui stok restoran
                        $restoStock->update(['current_stok' => $stockAvailable]);
                    }

                    // ================================== Kupon ===================================
                    if ($order->total_price >= 100000) {
                        $timestamp = time();
                        $randomSeed = $timestamp % 10000;
                        $code = str_pad(mt_rand($randomSeed, 9999), 6, '0', STR_PAD_LEFT);

                        $kupon = [
                            'order_id' => $order->id,
                            'code' => 'VMND'.$code,
                        ];

                        $totalKupon = ($order->total_price / 100000) - 1; // Hitung jumlah kupon tambahan

                        // Loop untuk membuat kupon tambahan berdasarkan kelipatan 25,000
                        $kupons = [$kupon];
                        for ($i = 1; $i <= $totalKupon; $i++) {
                            $timestamp = time();
                            $randomSeed = $timestamp % 10000;
                            $kuponCode = 'VMND2' . str_pad(mt_rand($randomSeed, 9999), 6, '0', STR_PAD_LEFT);
                            $kupons[] = [
                                'order_id' => $order->id,
                                'code' => $kuponCode
                            ];
                        }

                        // dd($kupons);
                        Kupon::insert($kupons);
                    }

                }
            }else if($order->billiard_id != null){
                $orderBilliard = OrderBilliard::where('order_id',$order->id)->get();
                foreach ($orderBilliard as $key => $item) {
                    $restoStock = Restaurant::where('id', $orderBilliard->restaurant_id)->first();
                    $stockAvailable = ($restoStock->current_stok - $item->quantity);

                    // Memperbarui stok restoran
                    $restoStock->update(['current_stok' => $stockAvailable]);
                }
            }


        // dd($latestOrder);


            $responseData = [
                'code' => 200,
                'updateStock' => true,
                'deleteCart' => true,
                'cart' => $order,
            ];

            return $responseData;
        } catch (\Throwable $th) {
            $responseData = [
                'code' => 500,
                'updateStock' => false,
                'deleteCart' => false,
                'cart' => $cart,
                'message' => $th->getMessage(),
            ];
            return $responseData;
        }
    }

    private function generateInvoice()
    {

        $today = Carbon::today();
        $formattedDate = $today->format('ymd');

        $lastOrder = Order::whereDate('updated_at', $today)->where('status_pembayaran', 'Paid')->orderBy('id','desc')->first();
        if ($lastOrder) {
            // Cek apakah order dibuat pada tanggal yang sama dengan hari ini
            $lastInvoiceNumber = $lastOrder->invoice_no;
            $lastOrderNumber = (int)substr($lastInvoiceNumber, 7);
            $nextOrderNumber = $lastOrderNumber + 1;
            // dd($nextOrderNumber);
        } else {
            $nextOrderNumber = 1;
        }

        $paddedOrderNumber = str_pad($nextOrderNumber, 3, '0', STR_PAD_LEFT);
        $invoiceNumber = $formattedDate . '-' . $paddedOrderNumber;

        return $invoiceNumber;
    }


}
