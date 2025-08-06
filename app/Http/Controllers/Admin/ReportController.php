<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;

class ReportController extends Controller
{
    // User-submitted reports management (not analytics)
    public function index()
    {
        $reports = Report::latest()->paginate(20);
        return view('admin.reports.index', compact('reports'));
    }

    public function show($id)
    {
        $report = Report::findOrFail($id);
        if (!$report->is_read) {
            $report->is_read = true;
            $report->save();
        }
        return view('admin.reports.show', compact('report'));
    }

    // Add more methods here as needed, e.g. resolve, mark as read, etc.
}
