<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\AppInfo; 


class AppInfoController extends Controller
{
    public function index()
    {

        $appInfo = AppInfo::first();

        return view('admin.app-info.index', compact('appInfo'));
    }


    public function create()
    {
        
        if (AppInfo::first()) {
            session()->flash('info', 'App Info already exists. Please edit it instead.');
            return redirect()->route('app-info.index'); 
        }

        return view('admin.app-info.create');
    }


    public function store(Request $request)
    {
        
        if (AppInfo::first()) {
            return response()->json(['status' => 0, 'error' => ['general' => 'App Info already exists. Please use the edit function.']]);
        }

        $validator = Validator::make($request->all(), [
            'app_name' => 'required|min:5|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            try {
                $appInfo = new AppInfo;
                $appInfo->app_name = $request->app_name;

                if ($request->file('logo')) {
                    $file = $request->file('logo');
                    $filename = 'images/app_info/' .time().$file->getClientOriginalName();
                    $file->move('images/app_info/', $filename);
                    $appInfo->logo = $filename;
                    $appInfo->logo_path = 'admin'; 
                } 

                $appInfo->save();

                return response()->json(['status' => 1, 'success' => 'App Information has been created!']);
            } catch (\Exception $e) {
                return response()->json(['status' => 2, 'error' => 'Something went wrong. Please try again.']);
            }
        }
    }


    public function edit($id) 
    {
        $appInfo = AppInfo::findOrFail($id);

        return view('admin.app-info.edit', compact('appInfo'));
    }


    public function update(Request $request,$id) 
    {
        $appInfo = AppInfo::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'app_name' => 'required|min:5|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            try {
                $appInfo->app_name = $request->app_name;

                if ($request->hasFile('logo')) {
                    if ($appInfo->logo && File::exists($appInfo->logo_path . $appInfo->logo)) {
                        File::delete($appInfo->logo_path . $appInfo->logo);
                    }

                    $file = $request->file('logo');
                    $filename = 'images/app_info/' . time() . '.' . $file->getClientOriginalExtension();
                    $file->move('images/app_info/', $filename);
                    $appInfo->logo = $filename;
                    $appInfo->logo_path = 'admin'; 
                }

                $appInfo->save();

                return response()->json(['status' => 1, 'success' => 'App Information has been updated!']);
            } catch (\Exception $e) {
                return response()->json(['status' => 2, 'error' => 'Something went wrong. Please try again.']);
            }
        }
    }
}
