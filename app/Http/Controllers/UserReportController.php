<?php

namespace App\Http\Controllers;

use App\Models\UserReport;
use Illuminate\Http\Request;

class UserReportController extends Controller
{
    public function create()
    {
        return view('user_report.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('user_reports', 'public');
                $imagePaths[] = $path;
            }
        }

        UserReport::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id(),
            'status' => 'open',
            'is_read' => false,
            'images' => json_encode($imagePaths),
        ]);

        return redirect()->back()->with('success', 'Report submitted!');
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
