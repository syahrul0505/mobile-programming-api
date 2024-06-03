<?php

namespace App\Http\Controllers;

use App\Imports\RestaurantImport;
use App\Models\Absen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class AbsenController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'Absen';
        $user = Auth::user();
        $data['absens'] = Absen::get()->where('user_id',$user->id);
        $data ['absen_masuk'] = Absen::where('user_id', $user->id)
            ->whereDate('date', now()->toDateString())
            ->exists();

        $data['absen_keluar'] = Absen::where('user_id', $user->id)
        ->whereDate('date', now()->toDateString())
        ->whereNotNull('end_time') // Pastikan end_time tidak kosong
        ->exists();
        
        return view('absen.index', $data);
    }
    public function absenMasuk(Request $request){
        $user = Auth::user();

        // Pastikan user belum absen pada hari ini
        $existingAttendance = Absen::where('user_id', $user->id)
            ->whereDate('date', now()->toDateString())
            ->first();

        if ($existingAttendance) {
            return redirect()->back()->with('failed', 'Anda sudah melakukan absen masuk.');
        }

        // Simpan waktu masuk
        $attendance = new Absen();
        $attendance->user_id = $user->id;
        $attendance->date = now()->toDateString();
        $attendance->start_time = now()->toTimeString();
        $attendance->save();

        return redirect()->back()->with('success', 'Absen masuk berhasil.');
    }

    public function absenKeluar(Request $request){
        $user = Auth::user();

        // Temukan atau buat entri absen pada hari ini
        $attendance = Absen::updateOrCreate(
            ['user_id' => $user->id, 'date' => now()->toDateString()],
            ['end_time' => now()->toTimeString()]
        );
    
        // Jika entri berhasil diupdate atau dibuat
        if ($attendance) {
            return redirect()->back()->with('success', 'Absen Keluar berhasil.');
        }
    
        return redirect()->back()->with('failed', 'Gagal melakukan absen Keluar.');
    }

    public function import(Request $request)
    {   
        try {
            //code...
            $import = new RestaurantImport();
            dd($request->file('file'));
            Excel::import($import, $request->file('file'));
            return view('dashboard.index');
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
