<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q'));

        $users = User::withCount('orders')
            ->withSum(['orders as spent' => fn ($q) => $q->where('status', '!=', 'cancelled')], 'total')
            ->when($search !== '', fn ($q) => $q->where(function ($w) use ($search) {
                $w->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
            }))
            ->orderByDesc('is_admin')->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users', 'search'));
    }
}
