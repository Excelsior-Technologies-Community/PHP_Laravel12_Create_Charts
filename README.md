# ✅ Project: laravel12_create_chart_example

## 📊 Laravel 12 + Chart.js Dynamic Chart Example

**Introduction**

This tutorial shows how to integrate **Chart.js** into a **Laravel 12** application and display charts using backend data. The example uses Blade views and the Chart.js CDN — **no npm or frontend build step is required**. This is intentionally simple and perfect for learning, quick demos, small dashboards, or interview projects.

> **Important:** This document **omits** the `npm install` / `npm run dev` step by design. We load Chart.js and Tailwind via CDN so there's no need for Vite/npm for this project.

---

## ⭐ Project Features

* Laravel 12
* Chart.js integration (CDN)
* Controller → View data flow
* Clean MVC structure
* No npm / Vite required (CDN-based)


---

## ⭐ Step 1: Create Laravel 12 Project

Run this command to create the project skeleton:

```bash
composer create-project laravel/laravel:^12.0 laravel12_chart_example
cd laravel12_chart_example
```

This creates a fresh Laravel 12 application in the `laravel12_chart_example` folder.

---

## ⭐ Step 2: Create Route

**File:** `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChartController;

Route::get('/', function () {
    return view('welcome');
});

// Chart Example Route
Route::get('/chart', [ChartController::class, 'index'])
     ->name('chart.index');
```

* `/chart` will display the Chart.js example page.
* The route points to `ChartController@index` which prepares data and returns the view.

---

## ⭐ Step 3: Create Chart Controller

Create controller:

```bash
php artisan make:controller ChartController
```

**File:** `app/Http/Controllers/ChartController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * ChartController
 * ----------------
 * Responsible for preparing chart data
 * and passing it to the view.
 */
class ChartController extends Controller
{
    /**
     * Display chart view
     */
    public function index()
    {
        // Sample dynamic data (can come from DB)
        $labels = ['January', 'February', 'March', 'April', 'May', 'June'];
        $data   = [12, 19, 3, 5, 2, 8];

        return view('chart', compact('labels', 'data'));
    }
}
```

**Explanation:**

* The controller prepares two arrays: `$labels` (x-axis) and `$data` (y-axis).
* We pass these to the Blade view named `chart` using `compact()`.
* In real projects you would fetch this data from a database or API rather than hard-coding it.

---

## ⭐ Step 4: Create Chart View

**File:** `resources/views/chart.blade.php`

This Blade view is responsible for rendering the chart UI.
It loads Chart.js and Tailwind CSS via CDN and displays dynamic chart data passed from the controller.

To keep JavaScript clean and editor-friendly, Laravel Blade data is passed using HTML data-* attributes instead of embedding Blade syntax directly inside JavaScript.

```html
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
```

---

## ⭐ Step 5: Run Project

Start the built-in server:

```bash
php artisan serve
```

Open in browser:

```
http://127.0.0.1:8000/chart
```

You should see the Chart.js bar chart rendered with the sample data.

---

## ⭐ Chart Types You Can Easily Switch

In the view, change `type: 'bar'` to any supported Chart.js type:

```js
type: 'line'
// or
type: 'pie'
// or
type: 'doughnut'
```

No backend change required.

---

## 📁 Final Project Structure

```
laravel12_chart_example
├── app/Http/Controllers/ChartController.php
├── resources/views/chart.blade.php
├── public/
├── routes/web.php
└── .env
├── package.json   // present but not required for CDN approach
```

---

✅ Your Laravel 12 Chart Example project is now complete and ready to use! 🎉
