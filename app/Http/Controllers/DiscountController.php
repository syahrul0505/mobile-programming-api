<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\HistoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DiscountController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:tag-list', ['only' => 'index']);
        // $this->middleware('permission:tag-create', ['only' => ['create','store']]);
        // $this->middleware('permission:tag-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:tag-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $data['page_title'] = 'Discount';
        $data['discounts'] = Discount::orderby('id', 'asc')->get();

        return view('master-data.discount.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Create Discount';
        $data['discount'] = Discount::orderBy('id', 'ASC')->get();

        return view('master-data.discount.create',$data);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'nullable',
            'harga' => 'nullable',
        ]);

        try {
            $discount = new Discount();
            $discount->nama = $validateData['nama'];
            $discount->harga = $validateData['harga'];

            $discount->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Tag '.$discount->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('master-data.discounts.index')->with(['success' => 'Discount added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('master-data.discounts.index')->with(['failed' => 'Discount added failed! '.$th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Discount';
        $data['discount'] = Discount::find($id);

        return view('master-data.discount.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'nama' => 'nullable',
            'harga' => 'nullable',
        ]);

        try {
            $discount = Discount::findOrFail($id);
            $discount->nama = $validateData['nama'];
            $discount->harga = $validateData['harga'];

            $discount->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Edit';
            $newHistoryLog->menu = 'Edit Tag '.$discount->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('master-data.discounts.index')->with(['success' => 'Discount edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('master-data.discounts.index')->with(['failed' => 'Discount edited Failed! '. $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $discount = Discount::findOrFail($id);
            $discount->delete();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete';
            $newHistoryLog->menu = 'Delete Tag '.$discount->nama;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
        });

        Session::flash('success', 'Discount deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
