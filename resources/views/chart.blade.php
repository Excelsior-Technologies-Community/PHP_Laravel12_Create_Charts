<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel 12 Chart Example</title>

    <!-- ✅ Chart.js library loaded using CDN -->
    <!-- This allows us to create charts without installing npm -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- ✅ Tailwind CSS via CDN for basic UI styling -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <!-- ✅ Main container card for the chart -->
    <div class="bg-white p-8 rounded shadow-lg w-full max-w-3xl">

        <!-- ✅ Page heading -->
        <h2 class="text-2xl font-bold text-center mb-6">
            Laravel 12 Chart Example
        </h2>

        <!-- ✅ Canvas element where Chart.js will render the chart -->
        <!-- ✅ Blade passes PHP data to HTML using data attributes -->
        <!-- ✅ data-labels = X-axis values -->
        <!-- ✅ data-values = Y-axis values -->
        <canvas
            id="myChart"
            data-labels='@json($labels)'
            data-values='@json($data)'>
        </canvas>
    </div>

    <!-- ✅ Pure JavaScript starts here -->
    <!-- ✅ No Blade syntax inside JS (best practice) -->
    <script>

        // ✅ Get the canvas element using its ID
        const canvas = document.getElementById('myChart');

        // ✅ Read labels data from HTML data attribute
        // ✅ Convert JSON string to JavaScript array
        const labels = JSON.parse(canvas.dataset.labels);

        // ✅ Read chart values from HTML data attribute
        // ✅ Convert JSON string to JavaScript array
        const data = JSON.parse(canvas.dataset.values);

        // ✅ Get 2D drawing context from canvas
        const ctx = canvas.getContext('2d');

        // ✅ Create new Chart instance
        new Chart(ctx, {

            // ✅ Chart type (bar / line / pie)
            type: 'bar',

            // ✅ Chart data configuration
            data: {
                labels: labels, // X-axis values

                datasets: [{
                    label: 'Monthly Data', // Chart legend label
                    data: data, // Y-axis values

                    // ✅ Bar color
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',

                    // ✅ Border color of bars
                    borderColor: 'rgba(54, 162, 235, 1)',

                    // ✅ Border thickness
                    borderWidth: 1
                }]
            },

            // ✅ Chart options
            options: {
                responsive: true, // Makes chart responsive

                scales: {
                    y: {
                        beginAtZero: true // Y-axis starts from 0
                    }
                }
            }
        });
    </script>

</body>
</html>
