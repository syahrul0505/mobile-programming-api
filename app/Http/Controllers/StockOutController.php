<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use App\Models\Material;
use App\Models\StockOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StockOutController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:stock-out-list', ['only' => 'index']);
        $this->middleware('permission:stock-out-create', ['only' => ['create','store']]);
        $this->middleware('permission:stock-out-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:stock-out-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data['page_title'] = 'Stok Out';
        // $data['stok_keluars'] = StockOut::orderby('id', 'asc')->get();
        $data['materials'] = Material::get();

        $type = $request->has('type') ? $request->type : 'day';
        $material = $request->has('material_id') ? $request->material_id : 'All';
        if ($type == 'day') {
            if ($material == 'All') {
                $stok = StockOut::whereDate('created_at', date('Y-m-d'))->get();
                // dd($stok);
            }else{
                $stok = StockOut::whereDate('created_at', $request->start_date)->when($request->material_id, function($q) use($request){{
                    return $q->where('material_id', $request->material_id);
                 }})->get();
            }
        } elseif ($type == 'monthly') {
            $stok = StockOut::whereMonth('created_at', date('m', strtotime($request->month)))->when($request->material_id, function($q) use($request){{
                return $q->where('material_id', $request->material_id);
             }})->get();
        } elseif ($type == 'yearly'){
            $stok = StockOut::whereYear('created_at', $request->year)->when($request->material_id, function($q) use($request){{
                return $q->where('material_id', $request->material_id);
            }})->get();
        }

        $data['stock_outs'] = $stok;

        return view('inventory.stock-out.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Tambah Stok Out';
        $data['stock_out'] = StockOut::get();
        $data['materials'] = Material::get();

        return view('inventory.stock-out.create',$data);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'material_id' => 'required',
            'material_out' => 'required',
            'description' => 'nullable',
        ]);

        try {
            $material = new StockOut();
            $material->material_id = $validateData['material_id'];
            $material->material_out = $validateData['material_out'];
            $material->description = $validateData['description'];

            $material->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Stok Out '.$material->material->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('stock-outs.index')->with(['success' => 'Stok Out added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['failed' => 'Stok Out added failed! '.$th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Stock Out';
        $data['stock_out'] = StockOut::find($id);
        $data['materials'] = Material::get();

        return view('inventory.stock-out.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'material_id' => 'required',
            'material_out' => 'required',
            'description' => 'nullable',
        ]);

        try {
            $material = StockOut::findOrFail($id);
            $material->material_id = $validateData['material_id'];
            $material->material_out = $validateData['material_out'];
            $material->description = $validateData['description'];


            $material->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Edit';
            $newHistoryLog->menu = 'Edit Stok Out '.$material->material->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('stock-outs.index')->with(['success' => 'Stok Out edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['failed' => 'Stok Out edited Failed! '. $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $stok_keluar = StockOut::findOrFail($id);
            $stok_keluar->delete();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete';
            $newHistoryLog->menu = 'Delete Stok Keluar '.$stok_keluar->material->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
        });

        Session::flash('failed', 'Stok Out deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
