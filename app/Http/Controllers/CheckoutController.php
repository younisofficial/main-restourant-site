<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Support\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function create()
    {
        $items = Cart::items();
        if ($items->isEmpty()) {
            return redirect()->route('menu')->with('error', 'Your cart is empty. Add some delicious food first!');
        }

        $subtotal = Cart::subtotal($items);
        $deliveryFee = Cart::deliveryFee($subtotal);

        return view('frontend.checkout', [
            'items' => $items,
            'subtotal' => $subtotal,
            'deliveryFee' => $deliveryFee,
            'total' => $subtotal + $deliveryFee,
            'user' => auth()->user(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:100',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:150',
            'address' => 'required|string|max:255',
            'notes' => 'nullable|string|max:500',
        ]);

        $items = Cart::items();
        if ($items->isEmpty()) {
            return redirect()->route('menu')->with('error', 'Your cart is empty.');
        }

        $subtotal = Cart::subtotal($items);
        $deliveryFee = Cart::deliveryFee($subtotal);

        $order = DB::transaction(function () use ($data, $items, $subtotal, $deliveryFee, $request) {
            $order = Order::create($data + [
                'order_number' => Order::generateNumber(),
                'user_id' => $request->user()?->id,
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $subtotal + $deliveryFee,
                'payment_method' => 'cod',
                'status' => 'pending',
            ]);

            foreach ($items as $item) {
                $order->items()->create([
                    'food_id' => $item->food->id,
                    'food_name' => $item->food->name,
                    'price' => $item->food->price,
                    'quantity' => $item->quantity,
                    'total' => $item->total,
                ]);
            }

            return $order;
        });

        Cart::clear();
        session(['last_order' => $order->order_number]);

        return redirect()->route('order.success', $order);
    }

    public function success(Order $order)
    {
        // Only the person who placed the order (or its owner) can see this page
        $isOwner = auth()->check() && (int) $order->user_id === (int) auth()->id();
        if (session('last_order') !== $order->order_number && ! $isOwner) {
            abort(404);
        }

        $order->load('items');

        return view('frontend.order-success', compact('order'));
    }
}
