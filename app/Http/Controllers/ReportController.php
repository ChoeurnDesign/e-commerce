<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Show the report form (general report).
     */
    public function create()
    {
        return view('reports.create');
    }

    /**
     * Store the submitted report with optional images saved in public/img/reports.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096', // max 4MB each
        ]);

        // Create report record (without images first)
        $report = new Report();
        $report->title = $request->input('title');
        $report->description = $request->input('description', '');
        $report->user_id = auth()->id();
        // Other report fields if needed
        $report->save();

        // Handle images upload if any
        if ($request->hasFile('images')) {
            $imagePaths = [];

            foreach ($request->file('images') as $image) {
                $path = $image->store('reports', 'public'); 
                $imagePaths[] = $path;
            }

            // Save JSON array of image paths to 'images' column
            $report->images = json_encode($imagePaths);
            $report->save();
        }

        return redirect()->back()->with('success', 'Report submitted successfully.');
    }



    /**
     * Show a single report.
     */
    public function show($id)
    {
        $report = Report::findOrFail($id);

        // Decode JSON images string to array
        $report->images = $report->images ? json_decode($report->images, true) : [];

        return view('admin.reports.show', compact('report'));
    }
}
