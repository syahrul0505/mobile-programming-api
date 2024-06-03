<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
use App\Models\HistoryLog;
use App\Models\OrderDetail;
use App\Models\Restaurant;
use App\Models\RestaurantAddOn;
use App\Models\RestaurantTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RestaurantController extends Controller
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
        $data['restaurants'] = Restaurant::orderby('name', 'asc')->get();

        return view('management-toko-online.restaurant.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Tambah Menu';
        $data['restaurant'] = Restaurant::get();
        $data['restaurant_pivots'] = RestaurantAddOn::get();
        $data['tags'] = Tag::get();
        $data['add_ons'] = AddOn::get();
        return view('management-toko-online.restaurant.create',$data);
    }

    public function store(Request $request)
    {
        try {

        $validateData = $request->validate([
            'name' => 'required',
            // 'category' => 'required',
            'price' => 'required',
            'price_discount' => 'nullable',
            // 'persentase' => 'nullable',
            // 'stock_per_day' => 'nullable',
            // 'current_stok' => 'nullable',
            'tag_id' => 'nullable',
            'status' => 'required',
            'modal' => 'nullable',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'nullable',
        ]);

            $price_discount = 0;
            $persentase = 0;
            $stockPerDay = 0;
            $restaurant = new Restaurant();
            $restaurant->name = $validateData['name'];
            // $restaurant->category = $validateData['category'];
            $restaurant->price = $request->price;
            $restaurant->price_discount = $price_discount;
            $restaurant->persentase = $persentase;
            $restaurant->current_stock = $request->stock_per_day + $request->stock_in;
            $restaurant->stock_per_day = $request->stock_per_day;
            $restaurant->status = $validateData['status'];
            $restaurant->modal = $validateData['modal'];
            $restaurant->description = $validateData['description'];
            $restaurant->code = 0;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/restaurant/');
                $image->move($destinationPath, $name);
                $restaurant->image = $name;
            }
            $restaurant->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add Restaurant '.$restaurant->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            $restaurantTags = [];
            if ($request->tag_id) {
                $restaurantTags = [];
                foreach ($request->tag_id as $key => $value) {

                    $restaurantTags[] = [
                        'restaurant_id' => $restaurant->id,
                        'tag_id' => $request->tag_id[$key],
                        // 'add_on_id' => $request->add_on_id[$key],
                    ];
                }
                RestaurantTag::insert($restaurantTags);
            }

            if ($request->add_on_id) {
                $restaurantAddOn = [];
                foreach ($request->add_on_id as $key => $value) {

                    $restaurantAddOn[] = [
                        'restaurant_id' => $restaurant->id,
                        'add_on_id' => $request->add_on_id[$key],
                    ];
                }
                RestaurantAddOn::insert($restaurantAddOn);
            }

            if ($restaurant->category == 'Makanan') {
                $restaurant->code = $this->getNextId('MKN', $restaurant->id) ;
            }else{
                $restaurant->code = $this->getNextId('MNM', $restaurant->id);
            }

            return redirect()->route('shop.index')->with(['success' => 'Restaurant added successfully!']);
        } catch (\Throwable $th) {
            // dd($th);
            return redirect()->back()->with(['failed' => 'Restaurant added failed! '.$th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Menu';
        $data['restaurant'] = Restaurant::findorFail($id);
        $data['tags'] = Tag::get();
        $data['add_ons'] = AddOn::get();
        $data['restaurant_tags'] = RestaurantTag::where("restaurant_id", $id)
        ->pluck('tag_id')
        ->all();
        dd($data['restaurant_tags']);
        $data['restaurant_add_on'] = RestaurantAddOn::where("restaurant_id",$id)
        ->pluck('add_on_id')
        ->all();

        return view('management-toko-online.restaurant.edit',$data);
    }

    public function show($id)
    {
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $price_discount = 0;
        $persentase = 0;
        $stockPerDay = 0;
        $validateData = $request->validate([
            'name' => 'required',
            // 'category' => 'required',
            'price' => 'required',
            // 'price_discount' => 'nullable',
            // 'persentase' => 'nullable',
            // 'stock_per_day' => 'nullable',
            'current_stok' => 'nullable',
            'tag_id' => 'nullable',
            'status' => 'required',
            'modal' => 'nullable',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'description-restaurant' => 'nullable',
        ]);

        // dd($request->stock_per_day);
        try {
            $restaurant = Restaurant::findOrFail($id);
            $restaurant->name = $validateData['name'];
            // $restaurant->category = $validateData['category'];
            $restaurant->price = $request->price;
            $restaurant->price_discount = $price_discount;
            $restaurant->persentase = $persentase;
            $restaurant->current_stock = $request->stock_per_day + $request->stock_in;
            $restaurant->stock_per_day = $request->stock_per_day;
            $restaurant->status = $validateData['status'];
            $restaurant->modal = $validateData['modal'];
            $restaurant->description = $validateData['description-restaurant'];
            $restaurant->code = 0;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/restaurant/');
                $image->move($destinationPath, $name);
                $restaurant->image = $name;
            }

            $restaurant->save();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Edit';
            $newHistoryLog->menu = 'Edit Restaurant '.$restaurant->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            $restaurant->restaurantTag()->delete();
            $restaurant->restaurantAddOn()->delete();

            if ($request->tag_id) {
                $restaurantTags = [];
                foreach ($request->tag_id as $key => $value) {

                    $restaurantTags[] = [
                        'restaurant_id' => $restaurant->id,
                        'tag_id' => $request->tag_id[$key],
                    ];
                }
                RestaurantTag::insert($restaurantTags);
            }

            if ($request->add_on_id && $request->add_on_id) {
                $restaurantAddOn = [];
                foreach ($request->add_on_id as $key => $value) {

                    $restaurantAddOn[] = [
                        'restaurant_id' => $restaurant->id,
                        'add_on_id' => $request->add_on_id[$key],
                    ];
                }
                RestaurantAddOn::insert($restaurantAddOn);
            }

            if ($restaurant->category == 'Makanan') {
                $restaurant->code = $this->getNextId('MKN', $restaurant->id) ;
            }else{
                $restaurant->code = $this->getNextId('MNM', $restaurant->id);
            }


            return redirect()->route('shop.index')->with(['success' => 'Restaurant edited successfully!']);
        } catch (\Throwable $th) {
            // dd($th);
            return redirect()->route('shop.index')->with(['failed' => 'Restaurant edited Failed! '. $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $restaurant = Restaurant::findOrFail($id);
            $restaurant->delete();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete';
            $newHistoryLog->menu = 'Delete Restaurant '.$restaurant->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
        });

        Session::flash('success', 'Restaurant deleted successfully!');
        return response()->json(['status' => '200']);
    }

    public function getNextId($category, $id){
        DB::table('restaurants')->where('id', $id)->update(['code' => $category.$id]);
        return 0;
    }
}
