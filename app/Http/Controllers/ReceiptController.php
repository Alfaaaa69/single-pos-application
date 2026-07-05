<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    /**
     * Display the receipt for printing.
     */
    public function show(Sale $sale)
    {
        $sale->load('items', 'user', 'cashShift');

        return view('receipt.thermal', compact('sale'));
    }
}
