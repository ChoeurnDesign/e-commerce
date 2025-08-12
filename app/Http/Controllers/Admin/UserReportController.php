<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserReport;

class UserReportController extends Controller
{
    public function index()
    {
        $reports = UserReport::latest()->paginate(20);
        return view('admin.reports.index', compact('reports'));
    }

    public function show($id)
    {
        $report = UserReport::findOrFail($id);
        if (!$report->is_read) {
            $report->is_read = true;
            $report->save();
        }
        return view('admin.reports.show', compact('report'));
    }
}
