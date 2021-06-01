<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Setting;

class SettingController extends Controller
{

    public function index() {
        $settings = Setting::get();
        return view('admin.banner.index')->with(['settings' => $settings]);
    }

    public function create() {
        return view('admin.banner.create');
    }

    public function store(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'banner_heading' => 'required',
                    'banner_heading_items' => 'required',
                    'banner_description' => 'required',
                    'banner_image' => 'required',
                    'banner_search_text' => 'required',
                    'banner_video_text' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
//        dd($request->all());
        $fileName = '';
        if ($request->hasFile('banner_image')) {
            $file = $request['banner_image'];
            $result = $this->uploadFile($file, 'images');
            if ($result['status'] == 1) {
                $fileName = $result['filename'];
            } else {
                $response['level'] = 'danger';
                $response['content'] = $result['error'];
                return redirect()->back();
            }
        }

        $setting = new Setting();
        $setting->banner_heading = $request['banner_heading'];
        $setting->banner_heading_items = $request['banner_heading_items'];
        $setting->banner_description = $request['banner_description'];
        $setting->banner_search_text = $request['banner_search_text'];
        $setting->banner_video_text = $request['banner_video_text'];
        $setting->banner_image = $fileName;
        if ($setting->save()) {
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Settings added Successfully.');
        } else {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Error while adding Settings');
        }
        return redirect()->route('admin.settings.index');
    }

    public function edit(Request $request, $id) {
        $setting = Setting::where('id', $id)->first();
        return view('admin.banner.create')->with(['setting' => $setting]);
    }

    public function update(Request $request, $id) {
        $validator = \Validator::make($request->all(), [
                    'banner_heading' => 'required',
                    'banner_heading_items' => 'required',
                    'banner_description' => 'required',
                    'banner_search_text' => 'required',
                    'banner_video_text' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $update['banner_heading'] = $request['banner_heading'];
        $update['banner_heading_items'] = $request['banner_heading_items'];
        $update['banner_description'] = $request['banner_description'];
        $update['banner_search_text'] = $request['banner_search_text'];
        $update['banner_video_text'] = $request['banner_video_text'];
        $update['banner_video_text'] = $request['banner_video_text'];
        if ($request->hasFile('banner_image')) {
            $file = $request['banner_image'];
            $result = $this->uploadFile($file, 'images');
            if ($result['status'] == 1) {
                $update['banner_image'] = $result['filename'];
            } else {
                $response['level'] = 'danger';
                $response['content'] = $result['error'];
                return redirect()->back();
            }
        }
        $setting = Setting::where('id', $id)->update($update);
        if ($setting) {
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Settings updated Successfully.');
        } else {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Error while updating Settings.');
        }
        return redirect()->route('admin.settings.index');
    }

}
