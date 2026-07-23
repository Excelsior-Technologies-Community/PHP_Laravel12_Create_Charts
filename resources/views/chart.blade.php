<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Interactive Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded shadow-lg w-full max-w-3xl">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Interactive Chart</h2>
            <select id="chartType" class="border rounded p-2">
                <option value="bar">Bar</option>
                <option value="line">Line</option>
                <option value="pie">Pie</option>
                <option value="doughnut">Doughnut</option>
                <option value="radar">Radar</option>
                <option value="polarArea">Polar Area</option>
            </select>
        </div>
        <div class="flex gap-2 mb-4">
            <button onclick="exportChart('myChart', 'png')" class="bg-green-500 text-white px-3 py-1 rounded">Export PNG</button>
            <button onclick="exportChart('myChart', 'jpeg')" class="bg-green-600 text-white px-3 py-1 rounded">Export JPEG</button>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Date Range:</label>
            <input type="date" id="startDate" class="border rounded p-2 mr-2">
            <input type="date" id="endDate" class="border rounded p-2">
            <button onclick="filterByDate()" class="bg-gray-500 text-white px-3 py-1 rounded">Apply</button>
        </div>
        <canvas id="myChart"></canvas>
    </div>
    <script>
        const chartTypeSelect = document.getElementById('chartType');
        const labels = @json($labels ?? ['Jan','Feb','Mar','Apr','May','Jun']);
        const salesData = @json($salesData ?? []);
        const ordersData = @json($ordersData ?? []);
        const singleData = @json($data ?? [1200, 1900, 300, 500, 200, 800]);
        const ctx = document.getElementById('myChart').getContext('2d');

        const datasets = [];
        if (salesData.length > 0 && ordersData.length > 0) {
            datasets.push({ label: 'Total Sales', data: salesData, backgroundColor: 'rgba(54,162,235,0.7)', borderColor: 'rgba(54,162,235,1)', borderWidth: 1 });
            datasets.push({ label: 'Total Orders', data: ordersData, backgroundColor: 'rgba(255,99,132,0.7)', borderColor: 'rgba(255,99,132,1)', borderWidth: 1 });
        } else {
            datasets.push({ label: 'Data', data: singleData, backgroundColor: 'rgba(54,162,235,0.7)', borderColor: 'rgba(54,162,235,1)', borderWidth: 1 });
        }

        let chart = new Chart(ctx, {
            type: chartTypeSelect.value,
            data: { labels: labels, datasets: datasets },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } },
                onClick: (e, elements) => {
                    if (elements.length > 0) {
                        const idx = elements[0].index;
                        alert('Label: ' + labels[idx] + '\nValue: ' + (datasets[0].data[idx] != null ? datasets[0].data[idx] : datasets[1]?.data[idx]));
                    }
                }
            }
        });

        chartTypeSelect.addEventListener('change', (e) => {
            chart.config.type = e.target.value;
            chart.update();
        });

        function exportChart(id, format) {
            const c = document.getElementById(id);
            const link = document.createElement('a');
            link.download = 'chart.' + format;
            link.href = c.toDataURL('image/' + format);
            link.click();
        }

        function filterByDate() {
            alert('Date filter applied');
        }
    </script>
</body>
</html>
