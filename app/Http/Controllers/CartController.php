<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Support\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::items();
        $subtotal = Cart::subtotal($items);
        $deliveryFee = Cart::deliveryFee($subtotal);

        return view('frontend.cart', [
            'items' => $items,
            'subtotal' => $subtotal,
            'deliveryFee' => $deliveryFee,
            'total' => $subtotal + $deliveryFee,
        ]);
    }

    public function add(Request $request, Food $food)
    {
        if (! $food->is_available) {
            return back()->with('error', 'Sorry, this item is not available right now.');
        }

        Cart::add($food->id, (int) $request->input('quantity', 1));

        if ($request->expectsJson()) {
            return response()->json([
                'message' => "{$food->name} added to cart",
                'count' => Cart::count(),
            ]);
        }

        return back()->with('success', "{$food->name} added to your cart.");
    }

    public function update(Request $request, Food $food)
    {
        $request->validate(['quantity' => 'required|integer|min:0|max:' . Cart::MAX_QTY]);
        Cart::update($food->id, (int) $request->quantity);

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    public function remove(Food $food)
    {
        Cart::remove($food->id);

        return redirect()->route('cart.index')->with('success', "{$food->name} removed from cart.");
    }

    public function clear()
    {
        Cart::clear();

        return redirect()->route('cart.index')->with('success', 'Your cart is now empty.');
    }
}
