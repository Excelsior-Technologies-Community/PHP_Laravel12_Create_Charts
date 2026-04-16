<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ChartController extends Controller
{
    /**
     * Sample chart (single dataset) for demo purposes
     */


    public function sampleChart()
    {
        $labels = ['January', 'February', 'March', 'April', 'May', 'June'];
        $data = [12, 19, 3, 5, 2, 8];

        // Pass $data, leave $salesData and $ordersData empty
        return view('chart', compact('labels'))
            ->with('data', $data)
            ->with('salesData', [])
            ->with('ordersData', []);
    }

    /**
     * Monthly Sales vs Orders chart (dual dataset)
     */
    public function monthlySalesOrders()
    {
        $labels = ['January', 'February', 'March', 'April', 'May', 'June'];
        $salesData = [1200, 1900, 300, 500, 200, 800];
        $ordersData = [300, 450, 150, 200, 120, 250]; // now pink bars visible
        return view('chart', compact('labels', 'salesData', 'ordersData'));
    }


}