<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const months = <?php echo json_encode(array_values($months ?? [])); ?>;
    const ordersByMonth = <?php echo json_encode($ordersChart ?? []); ?>;
    const revenueByMonth = <?php echo json_encode($revenueChart ?? []); ?>;
    const userTypes = <?php echo json_encode($userTypes ?? ['Regular', 'Admin']); ?>;
    const userTypeCounts = <?php echo json_encode($userTypeCounts ?? [0, 0]); ?>;
    const reportsStatusData = <?php echo json_encode($reportsStatusData ?? [0, 0]); ?>;
    const reportsStatusLabels = <?php echo json_encode($reportsStatusLabels ?? ['Open', 'Resolved']); ?>;

    new Chart(document.getElementById('ordersByMonthChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Orders',
                data: ordersByMonth,
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99,102,241,0.1)',
                fill: true,
                tension: 0.3,
            }]
        }
    });

    new Chart(document.getElementById('revenueByMonthChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Revenue',
                data: revenueByMonth,
                borderColor: '#16a34a',
                backgroundColor: 'rgba(34,197,94,0.1)',
                fill: true,
                tension: 0.3,
            }]
        }
    });

    new Chart(document.getElementById('customersByTypeChart'), {
        type: 'pie',
        data: {
            labels: userTypes,
            datasets: [{
                data: userTypeCounts,
                backgroundColor: ['#6366f1', '#f59e42'],
            }]
        }
    });

    new Chart(document.getElementById('reportsStatusChart'), {
        type: 'doughnut',
        data: {
            labels: reportsStatusLabels,
            datasets: [{
                data: reportsStatusData,
                backgroundColor: ['#ef4444','#10b981'],
            }]
        }
    });
</script>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/dashboard/reports-dash/_chart-scripts.blade.php ENDPATH**/ ?>