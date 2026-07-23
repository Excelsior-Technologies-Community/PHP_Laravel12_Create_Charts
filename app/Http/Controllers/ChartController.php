<?php

namespace App\Http\Controllers;

use App\Models\Chart;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function index()
    {
        $charts = Chart::all();
        return view('dashboard', compact('charts'));
    }

    public function create()
    {
        return view('charts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:bar,line,pie,doughnut,radar,polarArea',
            'labels' => 'required|json',
            'values' => 'required|json',
            'theme' => 'nullable|string|in:light,dark',
        ]);

        $validated['options'] = json_decode($validated['options'] ?? '{}', true);

        Chart::create($validated);

        return redirect()->route('dashboard')->with('success', 'Chart created successfully.');
    }

    public function edit(Chart $chart)
    {
        return view('charts.edit', compact('chart'));
    }

    public function update(Request $request, Chart $chart)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:bar,line,pie,doughnut,radar,polarArea',
            'labels' => 'required|json',
            'values' => 'required|json',
            'theme' => 'nullable|string|in:light,dark',
        ]);

        $validated['options'] = json_decode($validated['options'] ?? '{}', true);

        $chart->update($validated);

        return redirect()->route('dashboard')->with('success', 'Chart updated successfully.');
    }

    public function destroy(Chart $chart)
    {
        $chart->delete();

        return redirect()->route('dashboard')->with('success', 'Chart deleted successfully.');
    }

    public function apiCharts()
    {
        $charts = Chart::all(['id', 'title', 'type', 'labels', 'values']);
        return response()->json($charts);
    }

    public function show(Chart $chart)
    {
        return response()->json($chart);
    }
}
