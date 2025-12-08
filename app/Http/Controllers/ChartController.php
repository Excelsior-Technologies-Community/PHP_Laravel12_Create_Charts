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
