<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class ReportPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'Report Penjualan';
        $data['orders'] = Order::orderby('id', 'desc')->get();

        $data['account_users'] = User::get();

        $type = $request->has('type') ? $request->type : 'day';
        $user = $request->has('user_id') ? $request->user_id : 'All';

        if ($type == 'day') {
            $date = $request->has('start_date') ? $request->start_date : date('Y-m-d');
            if ($user == 'All') {
                $stok = Order::whereDate('created_at', $date)
                            ->where('status_pembayaran', 'Paid')
                            ->orderBy('id', 'desc')
                            ->get();
            } else {
                $stok = Order::whereDate('created_at', $date)
                            ->where('user_id', $request->user_id)
                            ->where('status_pembayaran', 'Paid')
                            ->orderBy('id', 'desc')
                            ->get();
            }
        } elseif ($type == 'monthly') {
            $month = $request->has('month') ? date('m', strtotime($request->month)) : date('m');
            $stok = Order::whereMonth('created_at', $month)
                        ->when($request->user_id, function ($q) use ($request) {
                            return $q->where('user_id', $request->user_id);
                        })
                        ->where('status_pembayaran', 'Paid')
                        ->orderBy('id', 'desc')
                        ->get();
        } elseif ($type == 'yearly') {
            $year = $request->has('year') ? $request->year : date('Y');
            $stok = Order::whereYear('created_at', $year)
                        ->when($request->user_id, function ($q) use ($request) {
                            return $q->where('user_id', $request->user_id);
                        })
                        ->where('status_pembayaran', 'Paid')
                        ->orderBy('id', 'desc')
                        ->get();
        }

        $totalPriceSum = $stok->sum('total_price');
        $modal = $stok->sum('modal');

        $data['total_price'] = $totalPriceSum;
        $data['modal'] = $modal;
        $data['orders'] = $stok;
        return view('report-penjualan.index', $data);


    }
}
