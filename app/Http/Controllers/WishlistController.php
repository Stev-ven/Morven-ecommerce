<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('product.image_groups')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        
        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Request $request)
    {
        $productId = $request->product_id;
        
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json([
                'status' => 'removed',
                'message' => 'Removed from wishlist',
                'count' => Wishlist::where('user_id', Auth::id())->count()
            ]);
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $productId
            ]);
            return response()->json([
                'status' => 'added',
                'message' => 'Added to wishlist',
                'count' => Wishlist::where('user_id', Auth::id())->count()
            ]);
        }
    }

    public function remove($id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();
        
        $wishlist->delete();
        
        return redirect()->route('wishlist.index')->with('success', 'Item removed from wishlist');
    }
}
