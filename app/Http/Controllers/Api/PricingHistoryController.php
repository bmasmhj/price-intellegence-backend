<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PricingHistory;
use App\Models\Product;

class PricingHistoryController extends Controller
{
    public function index(Product $product)
    {
        $history = PricingHistory::where('product_id', $product->id)
            ->orderByDesc('created_at')
            ->paginate(20);

        return response()->json($history);
    }
}
