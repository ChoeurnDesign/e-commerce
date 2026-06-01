<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SalesReportExport;
use App\Http\Controllers\Controller;
use App\Services\Report\SalesReportService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SalesReportController extends Controller
{
    /**
     * Build a report service from the request's range params.
     */
    protected function makeReport(Request $request): SalesReportService
    {
        $range = $request->input('range', '30d');
        $from  = $request->input('from');
        $to    = $request->input('to');

        return new SalesReportService($range, $from, $to);
    }

    /**
     * Main sales report dashboard.
     */
    public function index(Request $request)
    {
        $report = $this->makeReport($request);

        return view('admin.sales-report.index', [
            'report'       => $report,
            'summary'      => $report->summary(),
            'series'       => $report->timeSeries(),
            'topProducts'  => $report->topProducts(10),
            'topSellers'   => $report->topSellers(10),
            'statuses'     => $report->statusBreakdown(),
            'payments'     => $report->paymentMethods(),
            'rangeKey'     => $report->getRangeKey(),
            'fromDate'     => $report->getFrom()->format('Y-m-d'),
            'toDate'       => $report->getTo()->format('Y-m-d'),
        ]);
    }

    /**
     * Download the report as CSV.
     */
    public function exportCsv(Request $request)
    {
        $report   = $this->makeReport($request);
        $filename = 'sales-report-' . $report->getFrom()->format('Ymd')
                  . '-' . $report->getTo()->format('Ymd') . '.csv';

        return Excel::download(new SalesReportExport($report), $filename, \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Download the report as Excel (.xlsx).
     */
    public function exportExcel(Request $request)
    {
        $report   = $this->makeReport($request);
        $filename = 'sales-report-' . $report->getFrom()->format('Ymd')
                  . '-' . $report->getTo()->format('Ymd') . '.xlsx';

        return Excel::download(new SalesReportExport($report), $filename);
    }

    /**
     * Print-friendly view (browser "Save as PDF").
     */
    public function print(Request $request)
    {
        $report = $this->makeReport($request);

        return view('admin.sales-report.print', [
            'report'      => $report,
            'summary'     => $report->summary(),
            'topProducts' => $report->topProducts(15),
            'topSellers'  => $report->topSellers(15),
            'statuses'    => $report->statusBreakdown(),
            'payments'    => $report->paymentMethods(),
            'generatedAt' => now(),
        ]);
    }
}
