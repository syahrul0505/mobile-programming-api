<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HistoryLogsController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'History Log';
        $data['breadcumb'] = 'History Log';
        $today = Carbon::yesterday();

        $data['logs'] = HistoryLog::whereDate('created_at', $today)->latest()->get();
        return view('history-log.index', $data);
        
    }
}
