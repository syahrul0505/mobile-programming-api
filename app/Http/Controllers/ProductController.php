<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use App\Models\Product;
use App\Models\ProductTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:restaurant-list', ['only' => 'index']);
        $this->middleware('permission:restaurant-create', ['only' => ['create','store']]);
        $this->middleware('permission:restaurant-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:restaurant-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Product';
        $data['products'] = Product::orderby('name', 'asc')->get();

        return view('management-toko-online.restaurant.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Add Product';
        $data['product'] = Product::get();
        $data['categorys'] = Tag::get();
        return view('management-toko-online.restaurant.create',$data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $validateData = $request->validate([
                'name' => 'required',
                'purchase_price' => 'nullable',
                'selling_price' => 'nullable',
                'category_id' => 'nullable',
                'status' => 'required',
                'tag_id' => 'nullable',
                'description' => 'nullable',
            ]);

            $product = new Product();
            $product->name = $validateData['name'];
            $product->purchase_price = $validateData['purchase_price'];
            $product->category_id = $validateData['category_id'];
            $product->selling_price = $validateData['selling_price'];
            $product->status = $validateData['status'];
            $product->description = $validateData['description'];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/product/');
                $image->move($destinationPath, $name);
                $product->image = $name;
            }
            
            $product->save();


            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Product '.$product->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            $productTags = [];
            if ($request->tag_id) {
                $productTags = [];
                foreach ($request->tag_id as $key => $value) {

                    $productTags[] = [
                        'product_id' => $product->id,
                        'tag_id' => $request->tag_id[$key],
                    ];
                }
                ProductTag::insert($productTags);
            }

            return redirect()->route('products.index')->with(['success' => 'Product added successfully!']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['failed' => 'Product added failed! '.$th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Product';
        $data['product'] = Product::findorFail($id);
        $data['categorys'] = Tag::get();
        $data['product_tags'] = ProductTag::where("product_id", $id)
        ->pluck('tag_id')
        ->all();
        return view('management-toko-online.restaurant.edit',$data);
    }

    public function show($id)
    {
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'purchase_price' => 'nullable',
            'selling_price' => 'nullable',
            'category)id' => 'nullable',
            'status' => 'required',
            'tag_id' => 'nullable',
            'description' => 'nullable',
        ]);

        try {
            $product = Product::findOrFail($id);
            $product->name = $validateData['name'];
            $product->purchase_price = $validateData['purchase_price'];
            $product->category_id = $validateData['category_id'];
            $product->selling_price = $validateData['selling_price'];
            $product->status = $validateData['status'];
            $product->description = $validateData['description'];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/product/');
                $image->move($destinationPath, $name);
                $product->image = $name;
            }

            $product->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Edit';
            $newHistoryLog->menu = 'Edit Product '.$product->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            $product->productTag()->delete();

            if ($request->tag_id) {
                $productTags = [];
                foreach ($request->tag_id as $key => $value) {

                    $productTags[] = [
                        'product_id' => $product->id,
                        'tag_id' => $request->tag_id[$key],
                    ];
                }
                ProductTag::insert($productTags);
            }

            return redirect()->route('products.index')->with(['success' => 'Product edited successfully!']);
        } catch (\Throwable $th) {
            // dd($th);
            return redirect()->route('products.index')->with(['failed' => 'Product edited Failed! '. $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $product = Product::findOrFail($id);
            $product->delete();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete';
            $newHistoryLog->menu = 'Delete Product '.$product->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
        });

        Session::flash('success', 'Product deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
