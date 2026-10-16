<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $orders = $user->orders()->withCount('items')->latest()->get();
        $reservations = $user->reservations()->latest('reservation_date')->get();

        return view('frontend.account', compact('user', 'orders', 'reservations'));
    }

    public function order(Request $request, Order $order)
    {
        abort_unless((int) $order->user_id === (int) $request->user()->id, 404);
        $order->load('items');

        return view('frontend.order-detail', compact('order'));
    }
}
