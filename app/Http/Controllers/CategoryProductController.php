<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoryProducts = CategoryProduct::all();
        return response()->json([
            'success' => true,
            'data' => $categoryProducts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'status'        => 'required|integer|in:0,1,2',
        ]);

        $categoryProduct = CategoryProduct::create([
            'name'          => $request->name,
            'slug'          => Str::slug($request->name),
            'description'   => $request->description,
            'status'        => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'data' => $categoryProduct
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryProduct $categoryProduct)
    {
        return response()->json([
            'success' => true,
            'data' => $categoryProduct->load('products')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryProduct $categoryProduct)
    {
        $request->validate([
            'name'          => 'sometimes|required|string|max:255',
            'description'   => 'nullable|string',
            'status'        => 'sometimes|required|integer|in:0,1,2',
        ]);

        if ($request->has('name')) {
            $categoryProduct->name = $request->name;
            $categoryProduct->slug = Str::slug($request->name);
        }
        if ($request->has('description')) {
            $categoryProduct->description = $request->description;
        }
        if ($request->has('status')) {
            $categoryProduct->status = $request->status;
        }

        $categoryProduct->save();

        return response()->json([
            'success' => true,
            'data' => $categoryProduct
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryProduct $categoryProduct)
    {
        $categoryProduct->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category product deleted successfully'
        ]);
    }
}
