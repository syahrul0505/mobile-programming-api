<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SupplierController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:supplier-list', ['only' => 'index']);
        $this->middleware('permission:supplier-create', ['only' => ['create','store']]);
        $this->middleware('permission:supplier-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:supplier-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Supplier List';
        $data['suppliers'] = Supplier::get();

        return view('master-data.supplier.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Create Supplier';

        return view('master-data.supplier.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'supplier_name' => 'required',
            'telephone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'description' => 'nullable',
        ]);

        // dd($request->all());
        try {

            $supplier = new Supplier();
            $supplier->supplier_name = $validateData['supplier_name'];
            $supplier->telephone = $validateData['telephone'];
            $supplier->email = $validateData['email'];
            $supplier->address = $validateData['address'];
            $supplier->description = $validateData['description'];
            $supplier->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Supplier '.$request->suppplier_name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('master-data.suppliers.index')->with(['success' => 'Supplier added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('master-data.suppliers.index')->with(['failed' => 'Supplier added failed! '.$th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['page_title'] = 'Detail Supplier';
        $data['suppliers'] = Supplier::find($id);
        // $data['supplier_details'] = DetailSupplier::get();

        return view('master-data.supplier.detail',$data);
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['page_title'] = 'Edit Supplier';
        $data['supplier'] = Supplier::find($id);

        return view('master-data.supplier.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'supplier_name' => 'required',
            'telephone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'description' => 'nullable',
        ]);

        try {

            $supplier = Supplier::findOrFail($id);
            $supplier->supplier_name = $validateData['supplier_name'];
            $supplier->telephone = $validateData['telephone'];
            $supplier->email = $validateData['email'];
            $supplier->address = $validateData['address'];
            $supplier->description = $validateData['description'];
            $supplier->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Edit';
            $newHistoryLog->menu = 'Edit Supplier '.$request->supplier_name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('master-data.suppliers.index')->with(['success' => 'Supplier edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('master-data.suppliers.index')->with(['failed' => 'Supplier edited Failed! '. $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $supplier = Supplier::findOrFail($id);
            $supplier->delete();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete';
            $newHistoryLog->menu = 'Delete Supplier '.$supplier->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
        });

        Session::flash('success', 'Asset Management deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
