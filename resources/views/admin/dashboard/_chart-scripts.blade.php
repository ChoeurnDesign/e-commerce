<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if(!empty($dailySales))
    // Sales Chart (Last 7 Days)
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($dailySales)) !!},
            datasets: [{
                label: 'Sales ($)',
                data: {!! json_encode(array_values($dailySales)) !!},
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
    @endif

    @if(!empty($orderStatusData))
    // Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($orderStatusData)) !!},
            datasets: [{
                data: {!! json_encode(array_values($orderStatusData)) !!},
                backgroundColor: [
                    '#FEF3C7', '#DBEAFE', '#E0E7FF', '#EDE9FE', '#D1FAE5', '#FEE2E2'
                ],
                borderColor: [
                    '#F59E0B', '#3B82F6', '#6366F1', '#8B5CF6', '#10B981', '#EF4444'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
    @endif
</script>
