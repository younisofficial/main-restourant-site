<?php

namespace App\Providers;

use App\Models\Contact;
use App\Models\Order;
use App\Models\Reservation;
use App\Support\Cart;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Older MySQL / MariaDB (XAMPP) index length fix
        Schema::defaultStringLength(191);

        Paginator::useBootstrapFive();

        // Cart badge in the website navbar
        View::composer('layouts.app', function ($view) {
            $view->with('cartCount', Cart::count());
        });

        // Notification badges in the admin sidebar
        View::composer('layouts.admin', function ($view) {
            $view->with('badges', [
                'orders' => Order::where('status', 'pending')->count(),
                'reservations' => Reservation::where('status', 'pending')->count(),
                'messages' => Contact::where('is_read', false)->count(),
            ]);
        });
    }
}
