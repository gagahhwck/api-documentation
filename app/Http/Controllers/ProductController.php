<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return response()->json([
                'success' => true,
                'message' => 'List of products',
                'data' => $products
            ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_product_id' => 'required|exists:category_products,id',
            'shop_id' => 'required|exists:shops,id',
        ]);

        $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        $product = Product::create($data);

        return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data' => $product->load(['category', 'shop'])
            ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json([
                'success' => true,
                'message' => 'Product details',
                'data' => $product
            ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'category_product_id' => 'sometimes|required|exists:category_products,id',
            'shop_id' => 'sometimes|required|exists:shops,id',
        ]);

        if (isset($data['name'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        }

        $product->update($data);

        return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'data' => $product->load(['category', 'shop'])
            ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ],200);
    }
}
