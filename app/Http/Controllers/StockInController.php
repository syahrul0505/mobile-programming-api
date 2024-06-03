<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use App\Models\Material;
use App\Models\StockIn;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StockInController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:stock-in-list', ['only' => 'index']);
        $this->middleware('permission:stock-in-create', ['only' => ['create','store']]);
        $this->middleware('permission:stock-in-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:stock-in-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data['page_title'] = 'Stok In';
        $data['materials'] = Material::orderby('id', 'asc')->get();

        $type = $request->has('type') ? $request->type : 'day';
        $material = $request->has('material_id') ? $request->material_id : 'All';
        if ($type == 'day') {
            if ($material == 'All') {
                $stok = StockIn::whereDate('created_at', date('Y-m-d'))->get();
                // dd($stok);
            }else{
                $stok = StockIn::whereDate('created_at', $request->start_date)->when($request->material_id, function($q) use($request){{
                    return $q->where('material_id', $request->material_id);
                 }})->get();
            }
        } elseif ($type == 'monthly') {
            $stok = StockIn::whereMonth('created_at', date('m', strtotime($request->month)))->when($request->material_id, function($q) use($request){{
                return $q->where('material_id', $request->material_id);
             }})->get();
        } elseif ($type == 'yearly'){
            $stok = StockIn::whereYear('created_at', $request->year)->when($request->material_id, function($q) use($request){{
                return $q->where('material_id', $request->material_id);
            }})->get();
        }

        $data['stock_ins'] = $stok;
        $data['users'] = User::get();

        return view('inventory.stock-in.index', $data);
    }


    public function create()
    {
        $data['page_title'] = 'Add Stok In';
        $data['stok-masuk'] = StockIn::get();
        $data['materials'] = Material::get();

        return view('inventory.stock-in.create',$data);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'material_id' => 'required',
            'material_in' => 'required',
            'description' => 'nullable',
        ]);

        try {
            $material = new StockIn();
            $material->material_id = $validateData['material_id'];
            $material->material_in = $validateData['material_in'];
            $material->description = $validateData['description'];

            $material->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Stok In '.$material->material->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('stock-ins.index')->with(['success' => 'Stok In added successfully!']);
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            return redirect()->back()->with(['failed' => 'Stok In added failed! '.$th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Stock In';
        $data['stock_in'] = StockIn::find($id);
        $data['materials'] = Material::get();

        return view('inventory.stock-in.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'material_id' => 'required',
            'material_in' => 'required',
            'description' => 'nullable',
        ]);

        try {
            $material = StockIn::findOrFail($id);
            $material->material_id = $validateData['material_id'];
            $material->material_in = $validateData['material_in'];
            $material->description = $validateData['description'];


            $material->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Edit';
            $newHistoryLog->menu = 'Edit Stok In '.$material->material->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('stock-ins.index')->with(['success' => 'Stok In Berhasil Diedit!']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['failed' => 'Stok In Gagal edited! '. $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $stok_masuk = StockIn::findOrFail($id);
            $stok_masuk->delete();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete';
            $newHistoryLog->menu = 'Delete Stok In '.$stok_masuk->material->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
        });

        Session::flash('success', 'Stok In deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
