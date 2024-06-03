<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use App\Models\Restaurant;
use App\Models\StockOutProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StockOutProductController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = 'Stok Out';
        $data['materials'] = StockOutProduct::orderby('id', 'asc')->get();
        $data['products'] = Restaurant::orderby('name', 'asc')->get();

        $type = $request->has('type') ? $request->type : 'day';
        $material = $request->has('restaurant_id') ? $request->restaurant_id : 'All';
        if ($type == 'day') {
            $date = $request->has('start_date') ? $request->start_date : date('Y-m-d');
            if ($material == 'All') {
                $stok = StockOutProduct::whereDate('created_at', $date)->orderBy('id', 'desc')->get();
            }else{
                $stok = StockOutProduct::whereDate('created_at', $request->start_date)->when($request->restaurant_id, function($q) use($request){{
                    return $q->where('restaurant_id', $request->restaurant_id);
                 }})->get();
            }
        } elseif ($type == 'monthly') {
            $stok = StockOutProduct::whereMonth('created_at', date('m', strtotime($request->month)))->when($request->restaurant_id, function($q) use($request){{
                return $q->where('restaurant_id', $request->restaurant_id);
             }})->get();
        } elseif ($type == 'yearly'){
            $stok = StockOutProduct::whereYear('created_at', $request->year)->when($request->restaurant_id, function($q) use($request){{
                return $q->where('restaurant_id', $request->restaurant_id);
            }})->get();
        }

        $data['stock_outs'] = $stok;
        // $data['users'] = User::get();

        return view('stok-product.stock-out.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Add Stok Out';
        $data['stok-keluar'] = StockOutProduct::get();
        $data['products'] = Restaurant::orderBy('name','asc')->get();

        return view('stok-product.stock-out.create',$data);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'product_id' => 'required',
            'product_out' => 'required',
            'description' => 'nullable',
        ]);

        try {
            $product = new StockOutProduct();
            $product->restaurant_id = $validateData['product_id'];
            $product->product_out = $validateData['product_out'];
            $product->description = $validateData['description'];

            $product->save();

            $restaurant = Restaurant::where('id', $request->product_id)->first();
            
            $restaurant->current_stock = $restaurant->current_stock - $request->product_out;
            $restaurant->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Stok Out '.$product->product->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('stock-out-products.index')->with(['success' => 'Stok Out added successfully!']);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->back()->with(['failed' => 'Stok Out added failed! '.$th->getMessage()]);
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
            $stockIn = StockOutProduct::findOrFail($id);
        
            // Ensure that the restaurant is retrieved correctly
            $restaurant = Restaurant::findOrFail($stockIn->restaurant_id);
        
            // Update current_stock
            $restaurant->current_stock += $stockIn->product_out;
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
        
        Session::flash('success', 'Stock Out deleted successfully!');
        return response()->json(['status' => '200']);
        
    }
}
