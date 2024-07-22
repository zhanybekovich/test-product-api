<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProductCollection;
use App\Http\Resources\V1\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->query('category_id');
        $stockId = $request->query('stock_id');
        $priceMin = $request->query('price_min') !== null ? (float)$request->query('price_min') : null;
        $priceMax = $request->query('price_max') !== null ? (float)$request->query('price_max') : null;
        $fields = $request->query('fields') ? explode(',', $request->query('fields')) : null;
        $sortBy = $request->query('sort_by', 'id');
        $sortDirection = $request->query('sort_direction', 'desc');

        $query = Product::where('is_published', true);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($stockId) {
            $query->whereHas('stocks', function ($query) use ($stockId) {
                $query->where('id', $stockId);
            });
        }

        if ($priceMin || $priceMax) {
            $query->where(function ($query) use ($priceMin, $priceMax) {
                if ($priceMin !== null) {
                    $query->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(prices, "$.price")) AS DECIMAL(10,2)) >= ?', [$priceMin]);
                }
                if ($priceMax !== null) {
                    $query->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(prices, "$.price")) AS DECIMAL(10,2)) <= ?', [$priceMax]);
                }
            });
        }

        $query->orderBy($sortBy, $sortDirection);

        $products = $query->paginate(2);

        return new ProductCollection($products, $fields);
    }

    public function show(string $id)
    {
        try {
            $product = Product::where('is_published', true)->findOrFail($id);
            return new ProductResource($product);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

}
