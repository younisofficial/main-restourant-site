<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImageUpload;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FoodController extends Controller
{
    use HandlesImageUpload;

    public function index(Request $request)
    {
        $search = trim((string) $request->query('q'));
        $categoryId = $request->query('category');

        $foods = Food::with('category')
            ->when($search !== '', fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->latest()->paginate(10)->withQueryString();

        $categories = Category::orderBy('sort_order')->get();

        return view('admin.foods.index', compact('foods', 'categories', 'search', 'categoryId'));
    }

    public function create()
    {
        $categories = Category::orderBy('sort_order')->get();
        if ($categories->isEmpty()) {
            return redirect()->route('admin.categories.create')->with('error', 'Please create a category first.');
        }

        return view('admin.foods.form', [
            'food' => new Food(['is_available' => true]),
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['image'] = $this->uploadImage($request->file('image'), 'foods');

        Food::create($data);

        return redirect()->route('admin.foods.index')->with('success', 'Food item added successfully.');
    }

    public function edit(Food $food)
    {
        $categories = Category::orderBy('sort_order')->get();

        return view('admin.foods.form', compact('food', 'categories'));
    }

    public function update(Request $request, Food $food)
    {
        $data = $this->validated($request, false);

        if ($data['name'] !== $food->name) {
            $data['slug'] = $this->uniqueSlug($data['name'], $food->id);
        }

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'foods', $food->image);
        }

        $food->update($data);

        return redirect()->route('admin.foods.index')->with('success', 'Food item updated successfully.');
    }

    public function destroy(Food $food)
    {
        $this->deleteImage($food->image);
        $food->delete();

        return back()->with('success', 'Food item deleted.');
    }

    private function validated(Request $request, bool $imageRequired): array
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:1|max:999999',
            'image' => ($imageRequired ? 'required' : 'nullable') . '|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        unset($data['image']);
        $data['is_available'] = $request->boolean('is_available');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_spicy'] = $request->boolean('is_spicy');

        return $data;
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'food';
        $slug = $base;
        $i = 2;
        while (Food::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
