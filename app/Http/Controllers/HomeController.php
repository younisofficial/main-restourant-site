<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Food;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount(['foods' => fn ($q) => $q->where('is_available', true)])
            ->orderBy('sort_order')->get();

        $featured = Food::with('category')
            ->where('is_available', true)
            ->where('is_featured', true)
            ->latest()->take(8)->get();

        return view('frontend.home', compact('categories', 'featured'));
    }

    public function menu(Request $request)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        $active = $request->query('category');
        $search = trim((string) $request->query('q'));

        $foods = Food::with('category')
            ->where('is_available', true)
            ->whereHas('category', fn ($q) => $q->where('is_active', true))
            ->when($active, fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $active)))
            ->when($search !== '', fn ($q) => $q->where(function ($w) use ($search) {
                $w->where('name', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%");
            }))
            ->orderBy('category_id')->orderBy('name')
            ->get();

        return view('frontend.menu', compact('categories', 'foods', 'active', 'search'));
    }

    public function about()
    {
        return view('frontend.about');
    }
}
