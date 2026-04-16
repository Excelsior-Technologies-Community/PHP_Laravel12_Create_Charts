<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laravel 12 Chart Example</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded shadow-lg w-full max-w-3xl">
        <h2 class="text-2xl font-bold text-center mb-6">
            @if(!empty($salesData) && !empty($ordersData))
                Monthly Sales vs Orders
            @else
                Sample Chart
            @endif
        </h2>

        <canvas id="myChart" data-labels='@json($labels)' data-values='@json($data ?? [])'
            data-sales='@json($salesData ?? [])' data-orders='@json($ordersData ?? [])'>
        </canvas>
    </div>

    <script>
        const canvas = document.getElementById('myChart');
        const labels = JSON.parse(canvas.dataset.labels);

        const salesData = JSON.parse(canvas.dataset.sales);
        const ordersData = JSON.parse(canvas.dataset.orders);
        const singleData = JSON.parse(canvas.dataset.values);

        const ctx = canvas.getContext('2d');

        // Decide chart type based on available data
        const datasets = [];
        if (salesData.length > 0 && ordersData.length > 0) {
            datasets.push({
                label: 'Total Sales',
                data: salesData,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            });
            datasets.push({
                label: 'Total Orders',
                data: ordersData,
                backgroundColor: 'rgba(255, 99, 132, 0.7)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            });
        } else {
            datasets.push({
                label: 'Sample Data',
                data: singleData,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            });
        }

        new Chart(ctx, {
            type: 'bar',
            data: { labels: labels, datasets: datasets },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>

</body>

</html>