<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class CartController extends Controller
{
    public function showCart()
    {
        // Get all cart items for the authenticated user with product details
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        // Calculate total price and total items for all items in the cart
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->product->amount * $item->quantity;
        });

        $totalItems = $cartItems->sum('quantity');

        return view('cart', compact('cartItems', 'totalAmount', 'totalItems'));
    }

    public function addToCart(Request $request)
    {
        $productId = $request->product_id;
        $product = Product::findOrFail($productId);

        // Check if product already exists in the cart
        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($cart) {
            // Increment the quantity if it already exists
            $cart->quantity += 1;
        } else {
            // Add new item to the cart
            $cart = new Cart();
            $cart->user_id = Auth::id();
            $cart->product_id = $product->id;
            $cart->quantity = 1;
        }
        $cart->save();

        // Return success message and the cart total amount
        $cartTotal = Cart::where('user_id', Auth::id())->sum('quantity');

        return response()->json([
            'message' => $product->name . ' has been added to your cart',
            'total' => $cartTotal
        ]);
    }
    // Update quantity of product in the cart
    public function updateQuantity(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cart) {
            $cart->quantity = $request->quantity;
            $cart->save();
        }

        return response()->json(['message' => 'Quantity updated']);
    }
    // Delete product from the cart
    public function deleteFromCart(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->delete();

        return response()->json(['message' => 'Item removed from cart']);
    }

    // Get cart total price
    public function cartTotal()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        $total = 0;

        foreach ($cartItems as $item) {
            $total += $item->product->amount * $item->quantity;
        }

        return response()->json(['total' => $total]);
    }
}
