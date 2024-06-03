<?php

namespace App\Http\Controllers;

use App\Models\AssetManagement;
use App\Models\HistoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AssetManagementController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:asset-management-list', ['only' => 'list']);
        $this->middleware('permission:asset-management-create', ['only' => ['create','store']]);
        $this->middleware('permission:asset-management-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:asset-management-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $data['page_title'] = 'Asset Management List';
        $data['asset_managements'] = AssetManagement::orderby('id', 'asc')->get();
        
        return view('master-data.asset-management.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Tambah Asset';
        $data['asset_management'] = AssetManagement::get();

        return view('master-data.asset-management.create',$data);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'qty' => 'required',
            'price' => 'required',
            'image' => 'nullable',
            'description' => 'nullable',
        ]);

        // dd($request->location);
        try {
            
            $asset_management = new AssetManagement();
            $asset_management->name = $validateData['name'];
            $asset_management->qty = $validateData['qty'];
            $asset_management->price = $validateData['price'];
            $asset_management->description = $validateData['description'];
            

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/asset-management/');
                $image->move($destinationPath, $name);
                $asset_management->image = $name;
            }

            $asset_management->save();
            
            
            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Asset '.$request->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('master-data.asset-managements.index')->with(['success' => 'Asset Management added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('master-data.asset-managements.index')->with(['failed' => 'Asset Management added failed! '.$th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Asset';
        $data['asset_management'] = AssetManagement::find($id);

        return view('master-data.asset-management.edit',$data);
    }
    
    public function show($id)
    {
        $data['page_title'] = 'Detail Asset';
        $data['asset_management'] = AssetManagement::find($id);
    
        return view('master-data.asset-management.detail',$data);
        # code...
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'qty' => 'required',
            'price' => 'required',
            'image' => 'nullable',
            'description' => 'nullable',
        ]);

        try {
            $replaceComma = str_replace(',', '',$request->price);

            $asset_management = AssetManagement::findOrFail($id);
            $asset_management->name = $validateData['name'];
            $asset_management->qty = $validateData['qty'];
            $asset_management->price = $validateData['price'];
            $asset_management->description = $validateData['description'];
            
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/asset-management/');
                $image->move($destinationPath, $name);
                $asset_management->image = $name;
            }

            $asset_management->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Edit';
            $newHistoryLog->menu = 'Edit Asset '.$request->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('master-data.asset-managements.index')->with(['success' => 'Asset Management edited successfully!']);
        } catch (\Throwable $th) {
            return redirect()->route('master-data.asset-managements.index')->with(['failed' => 'Asset Management edited Failed! '. $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $asset_management = AssetManagement::findOrFail($id);
            $asset_management->delete();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete';
            $newHistoryLog->menu = 'Delete Asset '.$asset_management->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
        });
        
        Session::flash('success', 'Asset Management deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
