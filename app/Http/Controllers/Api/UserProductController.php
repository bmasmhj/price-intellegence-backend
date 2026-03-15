<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\UserProduct;
use Illuminate\Http\Request;

class UserProductController extends Controller
{
    public function index(Request $request)
    {
        $query = UserProduct::with([
            'products' => function ($query) {
                $query->with('company')->withCount('pricingHistory');
            }
        ]);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('barcode', 'like', "%{$request->search}%");
            });
        }

        $paginated = $query->paginate($request->per_page);

        // Transform: aggregate competitor prices into dynamic company columns
        $paginated->getCollection()->transform(function ($userProduct) {
            $companies = [];
            foreach ($userProduct->products as $product) {
                if ($product->company) {
                    $companies[$product->company->company_name] = [
                        'product_id' => $product->id,
                        'price' => $product->price,
                        'rrp_price' => $product->rrp_price,
                        'price_change_percent' => $product->price_change_percent,
                        'price_direction' => $product->price_direction,
                        'updated_at' => $product->updated_at,
                        'has_history' => ($product->pricing_history_count > 0),
                    ];
                }
            }

            return [
                'id' => $userProduct->id,
                'name' => $userProduct->name,
                'barcode' => $userProduct->barcode,
                'cost_price' => $userProduct->cost_price,
                'companies' => $companies,
            ];
        });

        return response()->json($paginated);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'barcode' => 'nullable|string|max:100|unique:user_products,barcode',
            'cost_price' => 'nullable|numeric|min:0',
        ]);

        $userProduct = UserProduct::create($validated);

        return response()->json($userProduct, 201);
    }

    public function show(UserProduct $userProduct)
    {
        return response()->json($userProduct);
    }

    public function update(Request $request, UserProduct $userProduct)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'barcode' => 'nullable|string|max:100|unique:user_products,barcode,' . $userProduct->id,
            'cost_price' => 'nullable|numeric|min:0',
        ]);

        $userProduct->update($validated);

        return response()->json($userProduct);
    }

    public function destroy(UserProduct $userProduct)
    {
        $userProduct->delete();

        return response()->json(['message' => 'User product deleted.']);
    }

    public function searchProductByUrl(Request $request)
    {
        $request->validate(['url' => 'required|string']);
        $products = Product::with('company')
            ->where('url', 'like', "%{$request->url}%")
            ->orderByDesc('id')
            ->get();
        return response()->json($products);
    }

    public function linkedProducts(UserProduct $userProduct)
    {
        $products = $userProduct->products()->with('company')->get();
        return response()->json($products);
    }

    public function linkProduct(Request $request, UserProduct $userProduct)
    {
        $request->validate(['product_id' => 'required|integer|exists:products,id']);

        $product = Product::findOrFail($request->product_id);

        $product->user_product_id = $userProduct->id;
        if ($userProduct->barcode) {
            $product->barcode = $userProduct->barcode;
        }
        $product->save();

        return response()->json(['message' => 'Product linked successfully', 'product' => $product]);
    }

    public function unlinkProduct(Request $request, UserProduct $userProduct)
    {
        $request->validate(['product_id' => 'required|integer|exists:products,id']);

        $product = Product::where('id', $request->product_id)
            ->where('user_product_id', $userProduct->id)
            ->firstOrFail();

        $product->user_product_id = null;
        $product->save();

        return response()->json(['message' => 'Product unlinked successfully']);
    }
}
