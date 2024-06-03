<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\User;
use Illuminate\Http\Request;

class ReportAbsensiController extends Controller
{
    public function index(Request $request){
        $data['page_title'] = 'Report Absensi';
        $data['orders'] = Absen::orderby('id', 'asc')->get();

        $data['users'] = User::get();

        $type = $request->has('type') ? $request->type : 'day';
        $user = $request->has('user_id') ? $request->user_id : 'All';

        if ($type == 'day') {
            $date = $request->has('start_date') ? $request->start_date : date('Y-m-d');
            if ($user == 'All') {
                $stok = Absen::whereDate('created_at', $date)
                            ->orderBy('id', 'asc')
                            ->get();
            } else {
                $stok = Absen::whereDate('created_at', $date)
                            ->where('user_id', $request->user_id)
                            ->orderBy('id', 'asc')
                            ->get();
            }
        } elseif ($type == 'monthly') {
            $month = $request->has('month') ? date('m', strtotime($request->month)) : date('m');
            $stok = Absen::whereMonth('created_at', $month)
                        ->when($request->user_id, function ($q) use ($request) {
                            return $q->where('user_id', $request->user_id);
                        })
                        ->orderBy('id', 'asc')
                        ->get();
        } elseif ($type == 'yearly') {
            $year = $request->has('year') ? $request->year : date('Y');
            $stok = Absen::whereYear('created_at', $year)
                        ->when($request->user_id, function ($q) use ($request) {
                            return $q->where('user_id', $request->user_id);
                        })
                        ->orderBy('id', 'asc')
                        ->get();
        }

        $totalPriceSum = $stok->sum('total_price');

        $data['total_price'] = $totalPriceSum;
        $data['absens'] = $stok;
        return view('report-absen.index', $data);


    }
}
