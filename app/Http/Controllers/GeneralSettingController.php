<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class GeneralSettingController extends Controller
{
    public function create()
    {
        // Check if no general setting exists
        $generalSetting = GeneralSetting::first();

        // If no setting exists, show the create form
        if (!$generalSetting) {
            return view('setting.general_setting.create');
        }

        return redirect()->route('setting.general_setting.index')->with('error', 'General settings already exist.');
    }

    public function store(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'system_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the validation rules as needed
        ]);

        // Check if a file has been uploaded
        if ($request->hasFile('system_logo')) {
            // Get the uploaded file
            $logo = $request->file('system_logo');
            
            // Store the file in the storage folder (you can change this to a different path if needed)
            $path = $logo->store('public/storage/system_logos');

            // Save the file path to the database
            $generalSetting = new GeneralSetting();
            $generalSetting->system_logo = $path;
            $generalSetting->save();

            return redirect()->route('setting.general_setting.create')->with('success', 'General settings created successfully!');
        } else {
            // Handle the case where no file was uploaded
            return redirect()->route('setting.general_setting.create')->with('error', 'No image uploaded!');
        }
    }

    public function index()
    {
        $generalSettings = GeneralSetting::all();

        return view('setting.general_setting.index', compact('generalSettings'));
    }
}
