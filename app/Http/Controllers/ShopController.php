<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shops = Shop::all();
        return response()->json([
            'success' => true,
            'data' => $shops
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'logo'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name'          => 'required|string|max:255',
            'address'       => 'nullable|string',
            'phone_number'  => 'nullable|string|max:20',
            'email'         => 'nullable|email|max:255',
            'description'   => 'nullable|string',
            'status'        => 'required|integer|in:0,1,2',
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $logoPath;
        }

        $data['slug'] = Str::slug($data['name']);

        $shop = Shop::create($data);
        $shop->shop_users()->create([
            'user_id' => auth()->id(),
            'role'    => 'owner',
        ]);
        return response()->json([
            'success' => true,
            'data' => $shop
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Shop $shop)
    {
        return response()->json([
            'success' => true,
            'data' => $shop->load(['products', 'shop_users.user'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shop $shop)
    {
        $data = $request->validate([
            'logo'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name'          => 'required|string|max:255',
            'address'       => 'nullable|string',
            'phone_number'  => 'nullable|string|max:20',
            'email'         => 'nullable|email|max:255',
            'description'   => 'nullable|string',
            'status'        => 'required|integer|in:0,1,2',
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $logoPath;
        }

        $data['slug'] = Str::slug($data['name']);

        $shop->update($data);
        return response()->json([
            'success' => true,
            'data' => $shop
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop)
    {
        $shop->products()->delete();
        $shop->shop_users()->delete();
        $shop->delete();
        return response()->json([
            'success' => true,
            'message' => 'Shop deleted successfully'
        ]);
    }
}
