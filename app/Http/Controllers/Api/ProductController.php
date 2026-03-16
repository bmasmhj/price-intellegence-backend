<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Fetch all products with pagination
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $products = Product::with('company')->paginate($perPage);
        return response()->json($products);
    }

    // Fetch products by company id with pagination
    public function byCompany($companyId, Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $products = Product::with('company')
            ->where('company_id', $companyId)
            ->paginate($perPage);
        return response()->json($products);
    }
}
