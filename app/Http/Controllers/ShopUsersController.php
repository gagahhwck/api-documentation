<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;

class ShopUsersController extends Controller
{
    /**
     * Display a listing of staff for a shop.
     */
    public function index(Shop $shop)
    {
        $staff = $shop->shop_users()->with('user')->get();
        return response()->json([
            'success' => true,
            'data' => $staff
        ]);
    }

    /**
     * Store a newly created staff member for a shop.
     */
    public function store(Request $request, Shop $shop)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role'    => 'required|string|in:owner,staff',
        ]);

        // Validasi: hanya boleh ada 1 owner per shop
        if ($data['role'] === 'owner') {
            $existingOwner = $shop->shop_users()->where('role', 'owner')->first();
            if ($existingOwner) {
                return response()->json([
                    'success' => false,
                    'message' => 'This shop already has an owner. Only one owner is allowed.'
                ], 422);
            }
        }

        // Cek apakah user sudah terdaftar di shop
        $existing = $shop->shop_users()->where('user_id', $data['user_id'])->first();
        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'User is already a member of this shop.'
            ], 422);
        }

        $shopUser = $shop->shop_users()->create([
            'user_id' => $data['user_id'],
            'role'    => $data['role'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Staff added successfully',
            'data'    => $shopUser->load('user')
        ], 201);
    }

    /**
     * Remove a staff member from a shop.
     */
    public function destroy(Shop $shop, User $user)
    {
        $shopUser = $shop->shop_users()->where('user_id', $user->id)->first();

        if (!$shopUser) {
            return response()->json([
                'success' => false,
                'message' => 'User is not a member of this shop.'
            ], 404);
        }

        $shopUser->delete();

        return response()->json([
            'success' => true,
            'message' => 'Staff removed successfully'
        ]);
    }
}

