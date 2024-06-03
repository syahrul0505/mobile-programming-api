<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use App\Models\Restaurant;
use App\Models\StockInProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StockInProductController extends Controller
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
        $data['materials'] = StockInProduct::orderby('id', 'asc')->get();

        $type = $request->has('type') ? $request->type : 'day';
        $material = $request->has('material_id') ? $request->material_id : 'All';
        if ($type == 'day') {
            $date = $request->has('start_date') ? $request->start_date : date('Y-m-d');
            if ($material == 'All') {
                $stok = StockInProduct::whereDate('created_at', $date)->orderBy('id', 'desc')->get();

                // dd($stok);
            }else{
                $stok = StockInProduct::whereDate('created_at', $request->start_date)->when($request->material_id, function($q) use($request){{
                    return $q->where('material_id', $request->material_id);
                 }})->get();
            }
        } elseif ($type == 'monthly') {
            $stok = StockInProduct::whereMonth('created_at', date('m', strtotime($request->month)))->when($request->material_id, function($q) use($request){{
                return $q->where('material_id', $request->material_id);
             }})->get();
        } elseif ($type == 'yearly'){
            $stok = StockInProduct::whereYear('created_at', $request->year)->when($request->material_id, function($q) use($request){{
                return $q->where('material_id', $request->material_id);
            }})->get();
        }

        $data['stock_ins'] = $stok;
        $data['users'] = User::get();

        return view('stok-product.stock-in.index', $data);
    }


    public function create()
    {
        $data['page_title'] = 'Add Stok In';
        $data['stok-masuk'] = StockInProduct::get();
        $data['products'] = Restaurant::get();

        return view('stok-product.stock-in.create',$data);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'product_id' => 'required',
            'product_in' => 'required',
            'description' => 'nullable',
        ]);

        try {
            $product = new StockInProduct();
            $product->restaurant_id = $validateData['product_id'];
            $product->product_in = $validateData['product_in'];
            $product->description = $validateData['description'];

            $product->save();

            $restaurant = Restaurant::where('id', $request->product_id)->first();
            
            $restaurant->current_stock = $restaurant->current_stock + $request->product_in;
            $restaurant->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Stok In '.$product->product->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('stock-in-products.index')->with(['success' => 'Stok In added successfully!']);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->back()->with(['failed' => 'Stok In added failed! '.$th->getMessage()]);
        }
    }

    public function show(){
        
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
            $stockIn = StockInProduct::findOrFail($id);
        
            // Ensure that the restaurant is retrieved correctly
            $restaurant = Restaurant::findOrFail($stockIn->restaurant_id);
        
            // Update current_stock
            $restaurant->current_stock -= $stockIn->product_in;
            $restaurant->save();
        
            // Delete the StockInProduct
            $stockIn->delete();
        
            // Create a new HistoryLog entry
            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = now();
            $newHistoryLog->type = 'Delete';
            $newHistoryLog->menu = 'Delete Stock In ' . $stockIn->product->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
        });
        
        Session::flash('success', 'Stock In deleted successfully!');
        return response()->json(['status' => '200']);
        
    }
}
