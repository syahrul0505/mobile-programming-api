<?php

namespace App\Http\Controllers;

use App\Models\OtherSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class OtherSettingController extends Controller
{
    public function index()
    {
        $data['page_title'] = 'Other Settings';

        $other_settings = OtherSetting::orderBy('id', 'ASC')->get()->first();

        if (!$other_settings) {
            $data['other_setting'] = [];
        }

        $data['other_setting'] = $other_settings;

        return view('master-data.other.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = Crypt::decryptString($id);

        if ($id == '0') {
           $other = new OtherSetting();
        } else {
            $other = OtherSetting::findorFail($id);
        }

        $validate = $request->validate([
            'pb01' => 'nullable|regex:/[0-9]/',
            'time_start' => 'nullable',
            'time_close' => 'nullable',
        
        ]);

        $other->pb01 = $validate['pb01'];
        $other->time_start = $validate['time_start'];
        $other->time_close = $validate['time_close'];
        $other->save();

        return redirect()->route('master-data.other-settings.index')->with(['success' => 'Data inserted or updated successfully!']);
    }
}
