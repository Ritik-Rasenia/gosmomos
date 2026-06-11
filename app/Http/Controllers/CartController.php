<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private function getOrCreateCart()
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(['user_id' => Auth::id()]);
        }

        $sessionId = session()->getId();
        return Cart::firstOrCreate(['session_id' => $sessionId]);
    }

    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cart->load('items.product', 'items.variant');
        
        return view('cart.index', compact('cart'));
    }

    public function getCartData()
    {
        $cart = $this->getOrCreateCart();
        $cart->load('items.product', 'items.variant');
        
        $totalItems = $cart->items->sum('quantity');
        $totalPrice = $cart->total;

        $items = $cart->items->map(function ($item) {
            $price = $item->variant ? $item->variant->price : $item->product->base_price;
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'name' => $item->product->name,
                'variant_name' => $item->variant ? $item->variant->name : null,
                'price' => $price,
                'quantity' => $item->quantity,
                'image' => $item->product->image,
                'subtotal' => $item->subtotal,
            ];
        });

        return response()->json([
            'success' => true,
            'items' => $items,
            'total_items' => $totalItems,
            'total_price' => $totalPrice,
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
            'special_instructions' => 'nullable|string',
        ]);

        $cart = $this->getOrCreateCart();
        
        // Check if item already exists in cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->where('variant_id', $request->variant_id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'variant_id' => $request->variant_id,
                'quantity' => $request->quantity,
                'special_instructions' => $request->special_instructions,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item added to cart successfully!',
            'cart_count' => $cart->items()->sum('quantity'),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::findOrFail($request->item_id);
        $cartItem->update(['quantity' => $request->quantity]);

        $cart = $this->getOrCreateCart();

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully!',
            'item_subtotal' => $cartItem->subtotal,
            'cart_total' => $cart->total,
            'cart_count' => $cart->items()->sum('quantity'),
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,id',
        ]);

        $cartItem = CartItem::findOrFail($request->item_id);
        $cartItem->delete();

        $cart = $this->getOrCreateCart();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart!',
            'cart_total' => $cart->total,
            'cart_count' => $cart->items()->sum('quantity'),
        ]);
    }
}
