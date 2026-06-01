<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sales Report — {{ $report->rangeLabel() }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            @page { margin: 14mm; }
        }
        body { font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, sans-serif; }
    </style>
</head>
<body class="bg-white text-gray-800 p-8 max-w-4xl mx-auto">

    {{-- Print toolbar (hidden when printing) --}}
    <div class="no-print mb-6 flex items-center justify-between bg-indigo-50 border border-indigo-100 rounded-xl px-4 py-3">
        <p class="text-sm text-indigo-800">Use your browser's <strong>Print → Save as PDF</strong> to export this report.</p>
        <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2 rounded-lg">
            Print / Save as PDF
        </button>
    </div>

    {{-- Header --}}
    <div class="flex items-center justify-between border-b-2 border-indigo-600 pb-4 mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">ShopExpress — Sales Report</h1>
            <p class="text-sm text-gray-500 mt-1">
                Period: <strong>{{ $report->rangeLabel() }}</strong>
                ({{ $report->getFrom()->format('M d, Y') }} – {{ $report->getTo()->format('M d, Y') }})
            </p>
        </div>
        <div class="text-right text-xs text-gray-400">
            <p>Generated</p>
            <p class="font-semibold text-gray-600">{{ $generatedAt->format('M d, Y g:i A') }}</p>
        </div>
    </div>

    {{-- Summary --}}
    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Summary</h2>
    <div class="grid grid-cols-3 gap-3 mb-8">
        @php
            $cards = [
                ['Gross Revenue', '$'.number_format($summary['gross_revenue'],2)],
                ['Orders', number_format($summary['order_count'])],
                ['Avg Order Value', '$'.number_format($summary['aov'],2)],
                ['Items Sold', number_format($summary['items_sold'])],
                ['Commission Earned', '$'.number_format($summary['commission'],2)],
                ['Seller Earnings', '$'.number_format($summary['seller_earnings'],2)],
                ['Payment Fees', '$'.number_format($summary['payment_fees'],2)],
                ['Refunds', '$'.number_format($summary['refunds'],2)],
                ['Net Platform Profit', '$'.number_format($summary['net_profit'],2)],
            ];
        @endphp
        @foreach($cards as $c)
        <div class="border border-gray-200 rounded-lg p-3 {{ $c[0]==='Net Platform Profit' ? 'bg-indigo-50 border-indigo-200' : 'bg-gray-50' }}">
            <p class="text-lg font-extrabold text-gray-900">{{ $c[1] }}</p>
            <p class="text-[11px] text-gray-500 uppercase tracking-wide">{{ $c[0] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Top Products --}}
    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Top Products</h2>
    <table class="w-full text-sm mb-8 border border-gray-200">
        <thead><tr class="bg-gray-100 text-left text-xs text-gray-600">
            <th class="px-3 py-2">#</th><th class="px-3 py-2">Product</th><th class="px-3 py-2">SKU</th>
            <th class="px-3 py-2 text-right">Units</th><th class="px-3 py-2 text-right">Revenue</th>
        </tr></thead>
        <tbody>
            @forelse($topProducts as $i => $p)
            <tr class="border-t border-gray-100">
                <td class="px-3 py-1.5 text-gray-400">{{ $i+1 }}</td>
                <td class="px-3 py-1.5">{{ $p['name'] }}</td>
                <td class="px-3 py-1.5 text-gray-500">{{ $p['sku'] }}</td>
                <td class="px-3 py-1.5 text-right">{{ number_format($p['units']) }}</td>
                <td class="px-3 py-1.5 text-right font-semibold">${{ number_format($p['revenue'],2) }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-3 py-3 text-center text-gray-400">No sales in this period</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- Top Sellers --}}
    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Top Sellers</h2>
    <table class="w-full text-sm mb-8 border border-gray-200">
        <thead><tr class="bg-gray-100 text-left text-xs text-gray-600">
            <th class="px-3 py-2">#</th><th class="px-3 py-2">Store</th>
            <th class="px-3 py-2 text-right">Orders</th><th class="px-3 py-2 text-right">Revenue</th>
            <th class="px-3 py-2 text-right">Commission</th><th class="px-3 py-2 text-right">Earnings</th>
        </tr></thead>
        <tbody>
            @forelse($topSellers as $i => $s)
            <tr class="border-t border-gray-100">
                <td class="px-3 py-1.5 text-gray-400">{{ $i+1 }}</td>
                <td class="px-3 py-1.5">{{ $s['store'] }}</td>
                <td class="px-3 py-1.5 text-right">{{ $s['orders'] }}</td>
                <td class="px-3 py-1.5 text-right font-semibold">${{ number_format($s['revenue'],2) }}</td>
                <td class="px-3 py-1.5 text-right">${{ number_format($s['commission'],2) }}</td>
                <td class="px-3 py-1.5 text-right">${{ number_format($s['earnings'],2) }}</td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-3 py-3 text-center text-gray-400">No sales in this period</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- Payment + Status side by side --}}
    <div class="grid grid-cols-2 gap-6">
        <div>
            <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Payment Methods</h2>
            <table class="w-full text-sm border border-gray-200">
                <thead><tr class="bg-gray-100 text-left text-xs text-gray-600">
                    <th class="px-3 py-2">Method</th><th class="px-3 py-2 text-right">Orders</th><th class="px-3 py-2 text-right">Total</th>
                </tr></thead>
                <tbody>
                    @forelse($payments as $pm)
                    <tr class="border-t border-gray-100">
                        <td class="px-3 py-1.5">{{ ucwords(str_replace('_',' ',$pm['method'])) }}</td>
                        <td class="px-3 py-1.5 text-right">{{ $pm['count'] }}</td>
                        <td class="px-3 py-1.5 text-right font-semibold">${{ number_format($pm['total'],2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-3 py-3 text-center text-gray-400">—</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>
            <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Order Status</h2>
            <table class="w-full text-sm border border-gray-200">
                <thead><tr class="bg-gray-100 text-left text-xs text-gray-600">
                    <th class="px-3 py-2">Status</th><th class="px-3 py-2 text-right">Count</th><th class="px-3 py-2 text-right">Total</th>
                </tr></thead>
                <tbody>
                    @forelse($statuses as $st)
                    <tr class="border-t border-gray-100">
                        <td class="px-3 py-1.5">{{ ucfirst($st['status']) }}</td>
                        <td class="px-3 py-1.5 text-right">{{ $st['count'] }}</td>
                        <td class="px-3 py-1.5 text-right font-semibold">${{ number_format($st['total'],2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-3 py-3 text-center text-gray-400">—</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <p class="text-center text-xs text-gray-400 mt-10 pt-4 border-t border-gray-200">
        ShopExpress Multi-Vendor Marketplace · Confidential Sales Report
    </p>
</body>
</html>
