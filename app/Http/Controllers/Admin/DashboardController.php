<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Food;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $notCancelled = fn ($q) => $q->where('status', '!=', 'cancelled');

        $stats = [
            'orders_total' => Order::count(),
            'orders_pending' => Order::where('status', 'pending')->count(),
            'sales_today' => Order::whereDate('created_at', today())->where($notCancelled)->sum('total'),
            'sales_total' => Order::where($notCancelled)->sum('total'),
            'reservations_pending' => Reservation::where('status', 'pending')->count(),
            'foods' => Food::count(),
            'customers' => User::where('is_admin', false)->count(),
            'unread_messages' => Contact::where('is_read', false)->count(),
        ];

        // last 7 days sales for the mini chart
        $week = collect(range(6, 0))->map(function ($daysAgo) use ($notCancelled) {
            $day = today()->subDays($daysAgo);

            return [
                'label' => $day->format('D'),
                'total' => (float) Order::whereDate('created_at', $day)->where($notCancelled)->sum('total'),
            ];
        });

        $recentOrders = Order::latest()->take(6)->get();
        $upcomingReservations = Reservation::where('reservation_date', '>=', today()->toDateString())
            ->where('status', '!=', 'cancelled')
            ->orderBy('reservation_date')->orderBy('reservation_time')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'week', 'recentOrders', 'upcomingReservations'));
    }
}
