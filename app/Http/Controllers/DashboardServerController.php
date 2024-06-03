<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OtherSetting;
use App\Models\OtherSettings;
use App\Models\Restaurant;
use App\Models\User;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\PrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use PhpSerial\PhpSerial;

class DashboardServerController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'Dashboard Kasir';
        $data['order_pivots'] = OrderDetail::orderBy('updated_at', 'ASC')->get();
        $data ['other_setting'] = OtherSetting::get()->first();

        if (!$request->has('start_date') || $request->start_date === null) {
            $orders = Order::whereDate('created_at', Carbon::today())
                // ->where('status_pembayaran', 'Paid')
                ->orderBy('invoice_no', 'desc')
                ->get();
        } else {
            $date = $request->start_date;
        
            $orders = Order::whereDate('created_at', $date)
                ->where('status_pembayaran', 'Paid')
                ->orderBy('invoice_no', 'desc')
                ->get();
        }
        // $query->where('status_pembayaran', 'Paid')->where('status_pesanan', 'process');
        // $query->orderByDesc('invoice_no');
        // $getNameCustomer = $query->pluck('name')->unique();

        // Get By Nama Customer
        // if ($request->has('nama_customer')) {
        //     $namaCustomer = $request->input('nama_customer');
        //     if ($namaCustomer != 'All') {
        //         $query->where('name', $namaCustomer);
        //     }
        // }

        // $orders = $query->get();

        $data['orders'] = $orders;
        // $data['nama_customers'] = $getNameCustomer;

        foreach ($orders as $order) {
            $order->elapsed_time = $this->calculateElapsedTime($order->created_at);
        }

        return view('process.server.dashboard', $data);

    }

    public function calculateElapsedTime($createdAt)
    {
        $now = Carbon::now();
        $created = Carbon::parse($createdAt);
        $elapsedTime = $created->diffForHumans($now);

        return $elapsedTime;
    }

    public function detail($id)
    {
        $data['orders'] = Order::findorFail($id);
        $data['orders_pivots'] = OrderDetail::orderBy('id', 'ASC')->get();

        return view('process.server.index',$data);
    }

    public function statusDashboard(Request $request)
    {
        try {
            $order = OrderDetail::where('id', $request->id)->first();
            if ($request->value == true) {
                $order->status_pemesanan = 'Selesai';
            }else{
                $order->status_pemesanan = 'Belum Selesai';
            }
            $order->update();
            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function statusDashboardAll(Request $request)
    {
        try {
            // $order = Order::find($request->orderId);
            // $order->status_pemesanan = 'Selesai';
            // $order->save();
            // $order = Order::where('id', $request->id)->update(['status_pemesanan' => 'Selesai']);
            $order = OrderDetail::where('order_id', $request->id)->update(['status_pemesanan' => 'Selesai']);
            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function statusUpdate(Request $request)
    {
        try {
            // $order = Order::find($request->get('id'));
            // $order->status_pemesanan = 'Clear';
            // $order->save();
            Order::where('id', $request->id)->update(['status_pesanan' => 'selesai']);
            return response()->json(['success' => true, 'message' => 'success']);
        } catch (\Throwable $th) {
            return response()->json(['failed' => false, 'message' => $th->getMessage()]);
        }
    }
    public function tes(Request $request,$id)
    {
        try {
            $order = Order::find($request->id);
            $order->status_pemesanan = 'Selesai';
            $order->save();
            // $order = Order::where('id', $request->id)->update(['status_pemesanan' => 'Selesai']);
            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['failed' => false, 'message' => $th->getMessage()]);
        }
    }

    public function show($id)
    {
        $data['current_time'] = Carbon::now()->format('Y-m-d H:i:s');

        $orders = Order::findOrFail($id);
        $data['other_setting'] = OtherSetting::get()->first();

        if ($orders->status_pembayaran !== 'Paid' || $orders->status_pesanan == null) {
            abort(404);
        }

        $data['orders'] = $orders;
        return PDF::loadview('process.server.pdf', $data)->stream('order-' . $orders->id . '.pdf');
    }

    public function changeOpenBill($id){
        $latestOrder = Order::findOrFail($id);

        if ($latestOrder) {
            // Ubah status pembayaran menjadi "Paid"
            $latestOrder->update(['open_bill' => 'Paid']);

        }
        return redirect()->route('kasir.dashboard.server')->with('success', 'Order Telah berhasil');
    }

    public function autoPrintButton(Request $request){
        $bluetoothAddress = 'COM4'; // Replace with the actual COM port of your Bluetooth printer

        try {
            // Create an instance of PhpSerial
            $serial = new PhpSerial();

            // Set the COM port for Bluetooth
            $serial->deviceSet($bluetoothAddress);

            // Open the connection
            $serial->deviceOpen('w');

            // Perform printing operations
            $serial->sendMessage("Test Print\n");

            // Close the connection
            $serial->deviceClose();

            echo "Print berhasil dilakukan!";
        } catch (\Throwable $e) {
            // Handle errors
            echo "Error: " . $e->getMessage();
        }
    }

    public function updatePayment(Request $request ,$id){
        try {
            if ($request->metode_pembayaran == null) {
                return redirect()->back()->with('failed', 'Silahkan Isi Metode Pembayaran');
            }
            Order::where('id', $id)->update(['metode_pembayaran' => $request->metode_pembayaran]);
            return redirect()->back()->with('success', 'Update Payment');
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['failed' => false, 'message' => $th->getMessage()]);
        }
    }

    public function updateOrder(Request $request ,$id){
        try {
            Order::where('id', $id)->update(['is_cancel' => true,'status_pembayaran' => 'Unpaid']);
            
            $order = Order::findorFail($id);
            Order::where('id', $id)->update(['is_cancel' => true,'status_pembayaran' => 'Unpaid']);

            foreach ($order->orderDetail as $key => $value) {
                // Assuming there's a relationship between OrderDetail and Restaurant models
                $restaurant = $value->restaurant;

                // Calculate the new stock after canceling the order
                $newStock = $restaurant->current_stock + $value->qty;

                // Update the current_stock in the database
                DB::table('restaurants')
                    ->where('id', $restaurant->id)
                    ->update(['current_stock' => $newStock]);
            }
            return redirect()->back()->with('success', 'Update Order');
        } catch (\Throwable $th) {
            return response()->json(['failed' => false, 'message' => $th->getMessage()]);
        }
    }
}
