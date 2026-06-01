@extends('layouts.admin')

@section('title', 'Sales Report')

@section('content')
@php
    $q = request()->only(['range', 'from', 'to']);   // preserve current filter for export/print links
@endphp

<div class="space-y-6">

    {{-- ══ HEADER ══ --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">Sales Report</h1>
                <p class="text-xs text-gray-500">{{ $report->rangeLabel() }} · {{ $fromDate }} → {{ $toDate }}</p>
            </div>
        </div>

        {{-- Export buttons --}}
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.sales-report.export.csv', $q) }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-gray-200 text-sm font-semibold text-gray-700 hover:border-green-300 hover:text-green-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                CSV
            </a>
            <a href="{{ route('admin.sales-report.export.xlsx', $q) }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-gray-200 text-sm font-semibold text-gray-700 hover:border-emerald-300 hover:text-emerald-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Excel
            </a>
            <a href="{{ route('admin.sales-report.print', $q) }}" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print / PDF
            </a>
        </div>
    </div>

    {{-- ══ DATE RANGE FILTER ══ --}}
    <form method="GET" action="{{ route('admin.sales-report.index') }}"
          class="bg-white rounded-2xl border border-gray-100 shadow-sm p-3 flex flex-wrap items-center gap-2"
          x-data="{ range: '{{ $rangeKey }}' }">
        @foreach(['today'=>'Today','7d'=>'7 Days','30d'=>'30 Days','90d'=>'90 Days','year'=>'This Year','all'=>'All Time'] as $key => $label)
            <a href="{{ route('admin.sales-report.index', ['range' => $key]) }}"
               class="px-4 py-2 rounded-xl text-sm font-medium transition
                      {{ $rangeKey === $key ? 'bg-indigo-600 text-white' : 'bg-gray-50 text-gray-600 hover:bg-gray-100' }}">
                {{ $label }}
            </a>
        @endforeach

        <span class="w-px h-6 bg-gray-200 mx-1"></span>

        {{-- Custom range --}}
        <input type="hidden" name="range" value="custom">
        <input type="date" name="from" value="{{ request('from', $fromDate) }}"
               class="px-3 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-300">
        <span class="text-gray-400 text-sm">→</span>
        <input type="date" name="to" value="{{ request('to', $toDate) }}"
               class="px-3 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-300">
        <button type="submit"
                class="px-4 py-2 rounded-xl bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold transition">
            Apply
        </button>
    </form>

    {{-- ══ KPI CARDS ══ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $kpis = [
                ['label'=>'Gross Revenue','value'=>'$'.number_format($summary['gross_revenue'],2),'icon'=>'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1','bg'=>'bg-green-100','fg'=>'text-green-600'],
                ['label'=>'Orders','value'=>number_format($summary['order_count']),'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2','bg'=>'bg-blue-100','fg'=>'text-blue-600'],
                ['label'=>'Avg Order Value','value'=>'$'.number_format($summary['aov'],2),'icon'=>'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6','bg'=>'bg-purple-100','fg'=>'text-purple-600'],
                ['label'=>'Items Sold','value'=>number_format($summary['items_sold']),'icon'=>'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4','bg'=>'bg-amber-100','fg'=>'text-amber-600'],
                ['label'=>'Commission Earned','value'=>'$'.number_format($summary['commission'],2),'icon'=>'M5 13l4 4L19 7','bg'=>'bg-pink-100','fg'=>'text-pink-600'],
                ['label'=>'Seller Earnings','value'=>'$'.number_format($summary['seller_earnings'],2),'icon'=>'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z','bg'=>'bg-teal-100','fg'=>'text-teal-600'],
                ['label'=>'Refunds','value'=>'$'.number_format($summary['refunds'],2),'icon'=>'M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6','bg'=>'bg-red-100','fg'=>'text-red-600'],
                ['label'=>'Net Platform Profit','value'=>'$'.number_format($summary['net_profit'],2),'icon'=>'M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12z','bg'=>'bg-indigo-100','fg'=>'text-indigo-600','highlight'=>true],
            ];
        @endphp
        @foreach($kpis as $k)
        <div class="bg-white rounded-2xl border {{ ($k['highlight'] ?? false) ? 'border-indigo-200 ring-1 ring-indigo-100' : 'border-gray-100' }} shadow-sm p-5">
            <div class="w-10 h-10 rounded-xl {{ $k['bg'] }} flex items-center justify-center mb-3">
                <svg class="w-5 h-5 {{ $k['fg'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $k['icon'] }}"/></svg>
            </div>
            <p class="text-2xl font-extrabold text-gray-900">{{ $k['value'] }}</p>
            <p class="text-xs text-gray-500 font-medium mt-1 uppercase tracking-wider">{{ $k['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- ══ REVENUE CHART ══ --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">
            Revenue &amp; Orders ({{ $series['granularity'] === 'month' ? 'monthly' : 'daily' }})
        </h2>
        <div class="h-72">
            @if(count($series['labels']))
                <canvas id="revenueChart"></canvas>
            @else
                <div class="flex flex-col items-center justify-center h-full text-gray-400">
                    <svg class="w-10 h-10 mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <p class="text-sm">No paid orders in this period</p>
                </div>
            @endif
        </div>
    </div>

    {{-- ══ TOP PRODUCTS + TOP SELLERS ══ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Top products --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Top Products</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="bg-gray-50 text-left text-[11px] text-gray-500 uppercase">
                        <th class="px-5 py-2 font-bold">#</th><th class="px-5 py-2 font-bold">Product</th>
                        <th class="px-5 py-2 font-bold text-right">Units</th><th class="px-5 py-2 font-bold text-right">Revenue</th>
                    </tr></thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($topProducts as $i => $p)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3 text-gray-400 font-semibold">{{ $i+1 }}</td>
                            <td class="px-5 py-3">
                                <p class="font-medium text-gray-800 truncate max-w-[200px]">{{ $p['name'] }}</p>
                                <p class="text-[10px] text-gray-400">{{ $p['sku'] }}</p>
                            </td>
                            <td class="px-5 py-3 text-right text-gray-700">{{ number_format($p['units']) }}</td>
                            <td class="px-5 py-3 text-right font-bold text-gray-900">${{ number_format($p['revenue'],2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-5 py-8 text-center text-gray-400 text-sm">No sales in this period</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Top sellers --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Top Sellers</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="bg-gray-50 text-left text-[11px] text-gray-500 uppercase">
                        <th class="px-5 py-2 font-bold">#</th><th class="px-5 py-2 font-bold">Store</th>
                        <th class="px-5 py-2 font-bold text-right">Revenue</th><th class="px-5 py-2 font-bold text-right">Commission</th>
                    </tr></thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($topSellers as $i => $s)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3 text-gray-400 font-semibold">{{ $i+1 }}</td>
                            <td class="px-5 py-3 font-medium text-gray-800 truncate max-w-[160px]">{{ $s['store'] }}</td>
                            <td class="px-5 py-3 text-right font-bold text-gray-900">${{ number_format($s['revenue'],2) }}</td>
                            <td class="px-5 py-3 text-right text-pink-600 font-semibold">${{ number_format($s['commission'],2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-5 py-8 text-center text-gray-400 text-sm">No sales in this period</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ══ PAYMENT METHODS + ORDER STATUS ══ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Payment Methods</h2>
            @forelse($payments as $pm)
            <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                <span class="text-sm font-medium text-gray-700">{{ ucwords(str_replace('_',' ',$pm['method'])) }}</span>
                <div class="text-right">
                    <span class="text-sm font-bold text-gray-900">${{ number_format($pm['total'],2) }}</span>
                    <span class="text-[11px] text-gray-400 ml-2">{{ $pm['count'] }} orders</span>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-400 py-4 text-center">No paid orders in this period</p>
            @endforelse
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Order Status Breakdown</h2>
            @forelse($statuses as $st)
            @php
                $stColor = match($st['status']) {
                    'completed' => 'bg-green-500', 'delivered' => 'bg-teal-500', 'shipped' => 'bg-purple-500',
                    'confirmed' => 'bg-indigo-500', 'processing' => 'bg-blue-500', 'pending' => 'bg-amber-500',
                    'cancelled' => 'bg-red-500', default => 'bg-gray-400',
                };
            @endphp
            <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                <span class="flex items-center gap-2 text-sm font-medium text-gray-700">
                    <span class="w-2.5 h-2.5 rounded-full {{ $stColor }}"></span>{{ ucfirst($st['status']) }}
                </span>
                <div class="text-right">
                    <span class="text-sm font-bold text-gray-900">{{ $st['count'] }}</span>
                    <span class="text-[11px] text-gray-400 ml-2">${{ number_format($st['total'],2) }}</span>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-400 py-4 text-center">No orders in this period</p>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const el = document.getElementById('revenueChart');
    if (!el) return;
    new Chart(el, {
        type: 'bar',
        data: {
            labels: @json($series['labels']),
            datasets: [
                {
                    label: 'Revenue ($)',
                    data: @json($series['revenue']),
                    backgroundColor: 'rgba(79, 70, 229, 0.85)',
                    borderRadius: 6,
                    yAxisID: 'y',
                    order: 2,
                },
                {
                    label: 'Orders',
                    data: @json($series['orders']),
                    type: 'line',
                    borderColor: '#EC4899',
                    backgroundColor: 'rgba(236,72,153,0.1)',
                    borderWidth: 2,
                    tension: 0.35,
                    pointRadius: 3,
                    pointBackgroundColor: '#EC4899',
                    yAxisID: 'y1',
                    order: 1,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: { legend: { position: 'top' } },
            scales: {
                y:  { position: 'left',  beginAtZero: true, title: { display: true, text: 'Revenue ($)' } },
                y1: { position: 'right', beginAtZero: true, grid: { drawOnChartArea: false }, title: { display: true, text: 'Orders' } },
            }
        }
    });
});
</script>
@endpush
@endsection
