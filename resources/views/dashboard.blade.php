<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chart Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen">
    <div class="container mx-auto p-4">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Chart Dashboard</h1>
            <div class="flex gap-2">
                <select id="chartTypeFilter" class="border rounded p-2 dark:bg-gray-800 dark:text-white">
                    <option value="all">All Types</option>
                    @foreach(['bar','line','pie','doughnut','radar','polarArea'] as $type)
                        <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
                <select id="themeFilter" class="border rounded p-2 dark:bg-gray-800 dark:text-white">
                    <option value="all">All Themes</option>
                    <option value="light">Light</option>
                    <option value="dark">Dark</option>
                </select>
                <button id="toggleTheme" class="bg-gray-600 text-white px-4 py-2 rounded">Toggle Theme</button>
                <a href="{{ route('charts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">+ New Chart</a>
            </div>
        </div>
        <div id="chartsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($charts as $chart)
            <div class="bg-white dark:bg-gray-800 p-4 rounded shadow chart-card" data-type="{{ $chart->type }}" data-theme="{{ $chart->theme }}">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ $chart->title }}</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('charts.edit', $chart) }}" class="text-blue-500 text-sm">Edit</a>
                        <form action="{{ route('charts.destroy', $chart) }}" method="POST" class="inline" onsubmit="return confirm('Delete this chart?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 text-sm">Delete</button>
                        </form>
                    </div>
                </div>
                <div class="flex justify-center gap-2 mb-2">
                    <button onclick="exportChart('canvas{{ $chart->id }}', 'png')" class="text-xs bg-green-500 text-white px-2 py-1 rounded">PNG</button>
                    <button onclick="exportChart('canvas{{ $chart->id }}', 'jpeg')" class="text-xs bg-green-600 text-white px-2 py-1 rounded">JPEG</button>
                </div>
                <div class="chart-container" data-labels='@json($chart->labels)' data-values='@json($chart->values)' data-type="{{ $chart->type }}" data-theme="{{ $chart->theme }}" id="chart{{ $chart->id }}">
                    <canvas id="canvas{{ $chart->id }}" class="w-full" height="250"></canvas>
                </div>
            </div>
            @endforeach
        </div>
        <div id="noCharts" class="hidden text-center text-gray-500 text-xl mt-10">No charts found.</div>
    </div>

    <script>
        const charts = {};

        function getThemeColors(theme) {
            if (theme === 'dark') {
                return {
                    text: '#e5e7eb',
                    grid: '#374151'
                };
            }
            return {
                text: '#374151',
                grid: '#e5e7eb'
            };
        }

        function renderCharts() {
            const containers = document.querySelectorAll('.chart-container');
            const typeFilter = document.getElementById('chartTypeFilter').value;
            const themeFilter = document.getElementById('themeFilter').value;
            let visibleCount = 0;

            containers.forEach(container => {
                const card = container.closest('.chart-card');
                const chartType = container.dataset.type;
                const theme = container.dataset.theme;
                const labels = JSON.parse(container.dataset.labels);
                const values = JSON.parse(container.dataset.values);
                const canvasId = 'canvas' + container.id.replace('chart', '');

                if (typeFilter !== 'all' && chartType !== typeFilter) {
                    card.style.display = 'none';
                    return;
                }
                if (themeFilter !== 'all' && theme !== themeFilter) {
                    card.style.display = 'none';
                    return;
                }
                card.style.display = 'block';
                visibleCount++;

                const canvas = document.getElementById(canvasId);
                if (!canvas) return;

                const ctx = canvas.getContext('2d');
                if (charts[canvasId]) charts[canvasId].destroy();

                const colors = getThemeColors(theme);
                const isCircular = ['pie','doughnut','polarArea'].includes(chartType);
                const backgroundColors = values.map((_, i) => `hsl(${(i * 360) / values.length}, 70%, 60%)`);
                const borderColor = colors.text;

                charts[canvasId] = new Chart(ctx, {
                    type: chartType,
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Data',
                            data: values,
                            backgroundColor: isCircular ? backgroundColors : 'rgba(54,162,235,0.7)',
                            borderColor: borderColor,
                            borderWidth: isCircular ? 2 : 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { labels: { color: colors.text } }
                        },
                        scales: isCircular ? {} : {
                            y: {
                                beginAtZero: true,
                                ticks: { color: colors.text },
                                grid: { color: colors.grid }
                            },
                            x: {
                                ticks: { color: colors.text },
                                grid: { color: colors.grid }
                            }
                        },
                        onClick: (e, elements) => {
                            if (elements.length > 0) {
                                const idx = elements[0].index;
                                alert('Label: ' + labels[idx] + '\nValue: ' + values[idx]);
                            }
                        }
                    }
                });
            });

            document.getElementById('noCharts').classList.toggle('hidden', visibleCount > 0);
        }

        function exportChart(canvasId, format) {
            const canvas = document.getElementById(canvasId);
            if (!canvas) return;
            const link = document.createElement('a');
            link.download = 'chart.' + format;
            link.href = canvas.toDataURL('image/' + format);
            link.click();
        }

        document.getElementById('toggleTheme').addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
        });

        document.getElementById('chartTypeFilter').addEventListener('change', renderCharts);
        document.getElementById('themeFilter').addEventListener('change', renderCharts);

        document.addEventListener('DOMContentLoaded', renderCharts);
    </script>
</body>
</html>
