<?php

namespace App\Exports;

use App\Services\Report\SalesReportService;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

/**
 * Exports a sales report (summary + breakdowns) to CSV / Excel.
 */
class SalesReportExport implements FromArray, WithHeadings, WithTitle
{
    public function __construct(protected SalesReportService $report) {}

    public function title(): string
    {
        return 'Sales Report';
    }

    public function headings(): array
    {
        return ['Section', 'Metric / Name', 'Value 1', 'Value 2', 'Value 3'];
    }

    public function array(): array
    {
        $s    = $this->report->summary();
        $rows = [];

        // ── Meta ────────────────────────────────────────────────────────────
        $rows[] = ['Report Range', $this->report->rangeLabel(),
                   $this->report->getFrom()->format('Y-m-d'),
                   $this->report->getTo()->format('Y-m-d'), ''];
        $rows[] = ['', '', '', '', ''];

        // ── Summary KPIs ────────────────────────────────────────────────────
        $rows[] = ['SUMMARY', 'Gross Revenue', $s['gross_revenue'], '', ''];
        $rows[] = ['SUMMARY', 'Orders',          $s['order_count'], '', ''];
        $rows[] = ['SUMMARY', 'Avg Order Value', $s['aov'], '', ''];
        $rows[] = ['SUMMARY', 'Items Sold',      $s['items_sold'], '', ''];
        $rows[] = ['SUMMARY', 'Commission Earned', $s['commission'], '', ''];
        $rows[] = ['SUMMARY', 'Seller Earnings', $s['seller_earnings'], '', ''];
        $rows[] = ['SUMMARY', 'Payment Fees',    $s['payment_fees'], '', ''];
        $rows[] = ['SUMMARY', 'Refunds',         $s['refunds'], '', ''];
        $rows[] = ['SUMMARY', 'Net Platform Profit', $s['net_profit'], '', ''];
        $rows[] = ['', '', '', '', ''];

        // ── Top Products ────────────────────────────────────────────────────
        $rows[] = ['TOP PRODUCTS', 'Name (SKU)', 'Units', 'Revenue', ''];
        foreach ($this->report->topProducts(20) as $p) {
            $rows[] = ['TOP PRODUCTS', $p['name'] . ' (' . $p['sku'] . ')', $p['units'], $p['revenue'], ''];
        }
        $rows[] = ['', '', '', '', ''];

        // ── Top Sellers ─────────────────────────────────────────────────────
        $rows[] = ['TOP SELLERS', 'Store', 'Orders', 'Revenue', 'Commission'];
        foreach ($this->report->topSellers(20) as $sl) {
            $rows[] = ['TOP SELLERS', $sl['store'], $sl['orders'], $sl['revenue'], $sl['commission']];
        }
        $rows[] = ['', '', '', '', ''];

        // ── Payment Methods ─────────────────────────────────────────────────
        $rows[] = ['PAYMENT METHODS', 'Method', 'Orders', 'Total', ''];
        foreach ($this->report->paymentMethods() as $pm) {
            $rows[] = ['PAYMENT METHODS', ucwords(str_replace('_', ' ', $pm['method'])), $pm['count'], $pm['total'], ''];
        }
        $rows[] = ['', '', '', '', ''];

        // ── Order Status ────────────────────────────────────────────────────
        $rows[] = ['ORDER STATUS', 'Status', 'Count', 'Total', ''];
        foreach ($this->report->statusBreakdown() as $st) {
            $rows[] = ['ORDER STATUS', ucfirst($st['status']), $st['count'], $st['total'], ''];
        }

        return $rows;
    }
}
