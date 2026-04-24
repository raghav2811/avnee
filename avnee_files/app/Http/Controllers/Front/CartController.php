<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Combo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Get combo details for variant selection modal
     */
    public function getComboDetails($id)
    {
        $combo = Combo::with(['products.variants' => function($q) {
            $q->where('stock', '>', 0);
        }])->findOrFail($id);

        return response()->json([
            'id' => $combo->id,
            'title' => $combo->title,
            'products' => $combo->products->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'image' => asset('storage/' . $product->image),
                    'variants' => $product->variants->map(function($v) {
                        return [
                            'id' => $v->id,
                            'size' => $v->size,
                            'color' => $v->colour,
                            'stock' => $v->stock
                        ];
                    })
                ];
            })
        ]);
    }
    /**
     * Get or create the active cart (Public for use in other controllers)
     */
    public function getCart()
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(['user_id' => Auth::id()]);
        }

        // Ensure session is started
        session()->start();
        return Cart::firstOrCreate(['session_id' => session()->getId()]);
    }

    /**
     * Display the cart page
     */
    public function index()
    {
        $cart = $this->getCart()->load('items.product', 'items.variant');
        $theme = session('theme', 'studio');
        return view('front.cart.index', compact('cart', 'theme'));
    }

    /**
     * Return a cart summary payload for mini-cart drawers.
     */
    public function summary()
    {
        $cart = $this->getCart()->load('items.product', 'items.variant');

        $items = $cart->items->map(function ($item) {
            $unitPrice = (float) ($item->price > 0 ? $item->price : ($item->product->price ?? 0));
            $lineTotal = $unitPrice * (int) $item->quantity;

            return [
                'id' => $item->id,
                'title' => $item->product->name ?? 'Product',
                'qty' => (int) $item->quantity,
                'size' => $item->variant->size ?? null,
                'unit_price' => $unitPrice,
                'line_total' => $lineTotal,
                'image' => $this->resolveCartItemImage($item),
                'product_url' => route('front.product.detail', $item->product->slug ?? $item->product_id),
            ];
        })->values();

        return response()->json([
            'item_count' => (int) $cart->items->sum('quantity'),
            'subtotal' => (float) $items->sum('line_total'),
            'items' => $items,
        ]);
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = $this->getCart();

        // Default to first variant if size was submitted but not translated to variant_id (for generic add)
        $product = Product::findOrFail($request->product_id);
        $variantId = $request->variant_id;
        $price = 0;

        if ($variantId) {
            $variant = ProductVariant::find($variantId);
            if ($variant) {
                $price = $variant->price;
                $variantId = $variant->id;
            } else {
                return response()->json(['success' => false, 'message' => 'Selected variant not found.'], 404);
            }
        } else {
            $price = $product->price;
            $variantId = null;
        }

        // Safety: ensure variant belongs to the product when provided.
        if ($variantId) {
            $belongs = ProductVariant::where('id', $variantId)->where('product_id', $product->id)->exists();
            if (!$belongs) {
                return response()->json(['success' => false, 'message' => 'Selected variant is invalid for this product.'], 422);
            }
        }

        if ($price <= 0) {
            // Check flash sale or default price if accessor fails
            $price = $product->variants->first()?->price ?? 0;
        }

        // Check if item already exists in cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->where('variant_id', $variantId)
            ->first();

        $discountedPrice = $price; // Fallback

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'variant_id' => $variantId,
                'quantity' => $request->quantity,
                'price' => $discountedPrice
            ]);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart',
                'cart_count' => $cart->items()->sum('quantity'),
            ]);
        }

        if ($request->buy_now == '1') {
            return redirect()->route('front.checkout.index');
        }

        return redirect()->back()->with('success', 'Item added to cart.');
    }

    /**
     * Add a full combo set to the cart
     */
    public function addCombo(Request $request, $id)
    {
        $combo = Combo::with('products')->findOrFail($id);
        $cart = $this->getCart();

        // Calculate per-item price share to sum up to combo price
        $count = $combo->products->count();
        if ($count == 0) return redirect()->back()->with('error', 'Combo is empty.');

        $pricePerItem = round($combo->price / $count, 2);

        foreach ($combo->products as $index => $product) {
            // For the last item, adjust rounding difference
            $itemPrice = ($index == $count - 1)
                ? ($combo->price - ($pricePerItem * ($count - 1)))
                : $pricePerItem;

            $variantId = null;
            if ($request->has('variants') && isset($request->variants[$product->id])) {
                $variantId = $request->variants[$product->id];
            }

            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'variant_id' => $variantId,
                'combo_id' => $combo->id,
                'quantity' => 1,
                'price' => $itemPrice
            ]);
        }

        return redirect()->route('front.checkout.index')->with('success', 'Combo deal added to your order!');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $cart = $this->getCart();
        $cartItem = CartItem::where('cart_id', $cart->id)->findOrFail($id);

        $cartItem->update(['quantity' => $request->quantity]);

        if ($request->ajax()) {
            return response()->json(['message' => 'Cart updated']);
        }

        return redirect()->back()->with('success', 'Cart updated.');
    }

    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        $cart = $this->getCart();
        $cartItem = CartItem::where('cart_id', $cart->id)->findOrFail($id);
        $cartItem->delete();

        if (request()->ajax()) {
            return response()->json(['message' => 'Item removed']);
        }

        return redirect()->back()->with('success', 'Item removed from cart.');
    }

    /**
     * Serve images from storage/app/public when public/storage is unavailable.
     */
    public function storageMedia(string $path)
    {
        $relativePath = str_replace('\\', '/', ltrim($path, '/'));

        if ($relativePath === '' || str_contains($relativePath, '..')) {
            abort(404);
        }

        $absolutePath = storage_path('app/public/' . $relativePath);
        if (!is_file($absolutePath)) {
            abort(404);
        }

        return Response::file($absolutePath, [
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }

    private function resolveCartItemImage(CartItem $item): string
    {
        $image = (string) ($item->product->image ?? '');
        if ($image === '') {
            return '';
        }

        if (filter_var($image, FILTER_VALIDATE_URL)) {
            return $image;
        }

        $normalized = str_replace('\\', '/', ltrim($image, '/'));

        if (Str::startsWith($normalized, ['http://', 'https://'])) {
            return $normalized;
        }

        if (Str::startsWith($normalized, 'storage/')) {
            $storageRelative = ltrim(substr($normalized, strlen('storage/')), '/');

            if (is_file(public_path($normalized))) {
                return asset($normalized);
            }

            if ($storageRelative !== '' && is_file(storage_path('app/public/' . $storageRelative))) {
                return route('front.media.storage', ['path' => $storageRelative]);
            }

            return asset($normalized);
        }

        if (Str::startsWith($normalized, 'images/')) {
            return asset($normalized);
        }

        if (is_file(public_path($normalized))) {
            return asset($normalized);
        }

        if (is_file(storage_path('app/public/' . $normalized))) {
            if (is_file(public_path('storage/' . $normalized))) {
                return asset('storage/' . $normalized);
            }

            return route('front.media.storage', ['path' => $normalized]);
        }

        return asset('storage/' . $normalized);
    }
}
