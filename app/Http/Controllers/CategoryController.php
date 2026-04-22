<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $query = Category::withCount('products');

        if ($request->filled('q')) {
            $query->where('name', 'like', '%'.$request->q.'%');
        }

        $categories = $query->paginate(15)->withQueryString();

        return view('admin.categories.index', [
            'categories' => $categories,
            'paginationView' => 'components::pagination',
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['name' => 'required|string|max:255']);
        Category::create($request->only('name'));

        return redirect()->route('admin.categories.index')->with('success', 'Категория создана');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $request->validate(['name' => 'required|string|max:255']);
        $category->update($request->only('name'));

        return redirect()->route('admin.categories.index')->with('success', 'Категория обновлена');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Категория удалена');
    }
}
