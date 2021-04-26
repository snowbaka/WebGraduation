<?php

namespace App\Http\Controllers\ControllerAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\OptionRequest;
use App\Models\Option;

class OptionController extends Controller
{

    public function index()
    {
        $settings = true;
        return view('admin.setting.index', compact('settings'));
    }
    public function update(Request $request)
    {

        $data = $request->all();
        foreach($data as $key => $value)
        {
            if($key != '_token' && $key != '_method')
                Option::put($key, $value);
        }
        if(($request->hasFile('fImages')))
        {
            @unlink(public_path('admin/dist/images/watermark.png'));
            $request->file('fImages')->move(public_path('admin/dist/images'), 'watermark.png');
        }
        return redirect()->route($data['_redirect'])->with('success', 'All changes have been successfully saved!');
    }


    public function tos()
    {
        return view('admin.setting.tos');
    }

    public function ads()
    {
        return view('admin.setting.ads');
    }
}
