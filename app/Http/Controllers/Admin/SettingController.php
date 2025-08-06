<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        // Fetch all settings
        $settings = Setting::all();

        return view('admin.settings.index', compact('settings'));
    }
}
