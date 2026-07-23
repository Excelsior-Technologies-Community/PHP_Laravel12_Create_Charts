<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ isset($chart) ? 'Edit' : 'Create' }} Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded shadow-lg w-full max-w-2xl">
        <h2 class="text-2xl font-bold mb-6">{{ isset($chart) ? 'Edit' : 'Create New' }} Chart</h2>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ isset($chart) ? route('charts.update', $chart) : route('charts.store') }}">
            @csrf
            @if(isset($chart))
                @method('PUT')
            @endif
            <div class="mb-4">
                <label class="block text-gray-700">Title</label>
                <input type="text" name="title" value="{{ old('title', isset($chart) ? $chart->title : '') }}" required class="w-full border rounded p-2">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Chart Type</label>
                <select name="type" id="chartType" class="w-full border rounded p-2">
                    @foreach(['bar','line','pie','doughnut','radar','polarArea'] as $type)
                        <option value="{{ $type }}" {{ old('type', isset($chart) ? $chart->type : 'bar') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Labels (comma separated)</label>
                <input type="text" id="labelsInput"
                    value="
                        @if(old('labels'))
                            {{ implode(',', json_decode(old('labels'), true) ?: []) }}
                        @elseif(isset($chart))
                            {{ implode(',', $chart->labels ?? []) }}
                        @else
                            Jan,Feb,Mar,Apr,May,Jun
                        @endif
                    "
                    required class="w-full border rounded p-2">
                <input type="hidden" name="labels" id="labelsJson" value="{{ old('labels', isset($chart) ? json_encode($chart->labels ?? []) : json_encode(['Jan','Feb','Mar','Apr','May','Jun'])) }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Values (comma separated)</label>
                <input type="text" id="valuesInput"
                    value="
                        @if(old('values'))
                            {{ implode(',', json_decode(old('values'), true) ?: []) }}
                        @elseif(isset($chart))
                            {{ implode(',', $chart->values ?? []) }}
                        @else
                            1200,1900,300,500,200,800
                        @endif
                    "
                    required class="w-full border rounded p-2">
                <input type="hidden" name="values" id="valuesJson" value="{{ old('values', isset($chart) ? json_encode($chart->values ?? []) : json_encode([1200,1900,300,500,200,800])) }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Theme</label>
                <select name="theme" class="w-full border rounded p-2">
                    <option value="light" {{ old('theme', isset($chart) ? $chart->theme : 'light') == 'light' ? 'selected' : '' }}>Light</option>
                    <option value="dark" {{ old('theme', isset($chart) ? $chart->theme : 'light') == 'dark' ? 'selected' : '' }}>Dark</option>
                </select>
            </div>
            <canvas id="previewChart" class="w-full mb-4" height="200"></canvas>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">{{ isset($chart) ? 'Update' : 'Create' }} Chart</button>
            <a href="{{ route('dashboard') }}" class="ml-2 text-gray-600">Cancel</a>
        </form>
    </div>
    <script>
        const labelsInput = document.getElementById('labelsInput');
        const valuesInput = document.getElementById('valuesInput');
        const labelsJson = document.getElementById('labelsJson');
        const valuesJson = document.getElementById('valuesJson');
        const chartType = document.getElementById('chartType');
        let preview = null;

        function parseInputs() {
            const labels = labelsInput.value.split(',').map(s => s.trim()).filter(Boolean);
            const values = valuesInput.value.split(',').map(s => parseFloat(s.trim()) || 0);
            labelsJson.value = JSON.stringify(labels);
            valuesJson.value = JSON.stringify(values);
            return { labels, values };
        }

        function updatePreview() {
            const { labels, values } = parseInputs();
            const ctx = document.getElementById('previewChart').getContext('2d');
            if (preview) preview.destroy();
            preview = new Chart(ctx, {
                type: chartType.value,
                data: {
                    labels: labels,
                    datasets: [{ label: 'Data', data: values, backgroundColor: 'rgba(54,162,235,0.7)', borderColor: 'rgba(54,162,235,1)', borderWidth: 1 }]
                },
                options: { responsive: true, scales: { y: { beginAtZero: true } } }
            });
        }

        labelsInput.addEventListener('input', updatePreview);
        valuesInput.addEventListener('input', updatePreview);
        chartType.addEventListener('change', updatePreview);
        updatePreview();
    </script>
</body>
</html>
