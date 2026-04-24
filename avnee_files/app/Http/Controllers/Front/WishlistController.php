<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Get user or session identifier
     */
    protected function getIdentifier()
    {
        if (Auth::check()) {
            return ['user_id' => Auth::id()];
        }
        
        session()->start();
        return ['session_id' => session()->getId()];
    }

    /**
     * Display wishlist page
     */
    public function index()
    {
        $identifier = $this->getIdentifier();
        
        $wishlistItems = Wishlist::where($identifier)
            ->with(['product', 'variant'])
            ->latest()
            ->get();
            
        $theme = session('theme', 'studio');
        return view('front.wishlist.index', compact('wishlistItems', 'theme'));
    }

    /**
     * Add or remove item from wishlist (Toggle)
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
        ]);

        $identifier = $this->getIdentifier();
        $conditions = array_merge($identifier, [
            'product_id' => $request->product_id,
            'variant_id' => $request->variant_id
        ]);

        $existing = Wishlist::where($conditions)->first();

        if ($existing) {
            $existing->delete();
            $message = 'Removed from wishlist';
            $action = 'removed';
        } else {
            Wishlist::create($conditions);
            $message = 'Added to wishlist';
            $action = 'added';
        }

        $count = Wishlist::where($identifier)->count();

        if ($request->ajax()) {
            return response()->json(['message' => $message, 'action' => $action, 'wishlist_count' => $count]);
        }

        return redirect()->back()->with('success', $message);
    }
    
    /**
     * Move item from wishlist to cart
     */
    public function moveToCart(Request $request, $id)
    {
        $identifier = $this->getIdentifier();
        $item = Wishlist::where($identifier)->with('product', 'variant')->findOrFail($id);
        
        // Add to Cart Logic
        $cart = app(CartController::class)->getCart();
        
        $price = $item->product->price;
        
        $cartItem = \App\Models\CartItem::updateOrCreate(
            [
                'cart_id' => $cart->id,
                'product_id' => $item->product_id,
                'variant_id' => $item->variant_id
            ],
            [
                'price' => $price
            ]
        );
        $cartItem->increment('quantity', 1);
        
        // Delete from Wishlist
        $item->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Item moved to cart successfully',
            'cart_count' => $cart->items()->sum('quantity')
        ]);
    }

    /**
     * Remove item (Explicit deletion)
     */
    public function remove($id)
    {
        $identifier = $this->getIdentifier();
        $item = Wishlist::where($identifier)->findOrFail($id);
        $item->delete();

        if (request()->ajax()) {
            return response()->json(['message' => 'Removed from wishlist']);
        }

        return redirect()->back()->with('success', 'Item removed from wishlist.');
    }
}
