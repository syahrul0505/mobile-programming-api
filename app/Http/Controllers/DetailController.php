<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
use App\Models\Restaurant;
use App\Models\RestaurantAddOn;
use App\Models\RestaurantTag;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function index($id){
        // dd();
        $data ['restaurant'] = Restaurant::find($id);
        $data ['restaurant_details'] = RestaurantTag::get();
        $data ['add_ons'] = AddOn::get();
        $data['restaurant_add_on'] = RestaurantAddOn::where("restaurant_id",$id)
        ->pluck('add_on_id')
        ->all();
        
        return view('shop.detail',$data);
    }
}
