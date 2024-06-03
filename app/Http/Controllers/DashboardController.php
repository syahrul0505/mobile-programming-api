<?php

namespace App\Http\Controllers;

use App\Models\AccountUser;
use App\Models\Biliard;
use App\Models\HistoryLog;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\MejaControl;
use App\Models\Order;
use App\Models\OrderPivot;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use App\Models\User;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    // function __construct()
    // {
    //     $this->middleware('permission:dashboard-control-list', ['only' => 'dashboardControl']);
    //     $this->middleware('permission:dashboard-control-create', ['only' => ['storeDashboardControl']]);
    //     $this->middleware('permission:dashboard-control-edit', ['only' => ['updateDashboardControl']]);
    //     $this->middleware('permission:dashboard-control-delete', ['only' => ['destroyDashboardControl']]);
    // }

    public function index(Request $request){
        $data['page_title'] = 'Dahsboard';
        $data['users'] = User::get();
        $data['products'] = Product::get();
        return view('dashboard.index', $data);
    }

    public function tes(Request $request){
        $data['page_title'] = 'Dahsboard';
        $data['users'] = User::get();
        $data['restaurants'] = Restaurant::get();
        return view('new-asset.app', $data);
    }

    private function getStockData($model, $request, $startDate, $endDate)
    {
        return $model::whereBetween('created_at', [$startDate, $endDate])
            ->when($request->material_id, function ($q) use ($request) {
                return $q->where('material_id', $request->material_id);
            })
            ->get()
            ->sum('material_masuk');
    }

    private function getDateRange($startDate, $endDate)
    {
        $dateRange = [];
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);

        for ($day = clone $start; $day <= $end; $day->modify('+1 day')) {
            $dateRange[] = $day->format('d');
        }

        return $dateRange;
    }

    private function getMembershipCount($level)
    {
        return AccountUser::whereHas('membership', function ($query) use ($level) {
            $query->where('level', $level);
        })->count();
    }



    public function dashboardControl() {
        $data['page_title'] = 'Dashboard Control';
        $data['meja_controls'] = MejaControl::orderBy('id', 'ASC')->get();
        $data['billiards'] = Biliard::orderBy('id', 'ASC')->get();

        return view('dashboard-control.index', $data);
    }

    public function storeDashboardControl(Request $request) {
        $validate = $request->validate([
            'address' => 'required',
            'billiard_id' => 'required|unique:meja_controls,billiard_id'
        ]);

        try {
            $dataControl = new MejaControl();

            $dataControl->address = $validate['address'];
            $dataControl->billiard_id = $validate['billiard_id'];

            $dataControl->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Controller '.$dataControl->Billiard->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('control-lamp')->with(['success' => 'Controller added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('control-lamp')->with(['failed' => 'Failed'.$th->getMessage()]);
        }
    }

    function updateDashboardControl(Request $request, $id) {
        $validate = $request->validate([
            'address' => 'required',
            'billiard_id_update' => 'required|unique:meja_controls,billiard_id,'.$id
        ]);

        try {
            $dataControl = MejaControl::findOrFail($id);

            $dataControl->address = $validate['address'];
            $dataControl->billiard_id = $validate['billiard_id_update'];

            $dataControl->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Edit';
            $newHistoryLog->menu = 'Edit Controller '.$dataControl->Billiard->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('control-lamp')->with(['success' => 'Controller edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('control-lamp')->with(['failed' => 'Failed'.$th->getMessage()]);
        }
    }

    public function destroyDashboardControl($id)
    {
        DB::transaction(function () use ($id) {
            $dataControl = MejaControl::findOrFail($id);

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete Controller '. $dataControl->Billiard->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            $dataControl->delete();
        });

        Session::flash('success', 'Controller deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
