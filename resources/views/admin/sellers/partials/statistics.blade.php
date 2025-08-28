<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <x-stat-card title="Total Sellers" :value="$stats['total'] ?? 0" color="gray"/>
    <x-stat-card title="Pending" :value="$stats['pending'] ?? 0" color="yellow"/>
    <x-stat-card title="Approved" :value="$stats['approved'] ?? 0" color="green"/>
    <x-stat-card title="Rejected" :value="$stats['rejected'] ?? 0" color="red"/>
</div>
