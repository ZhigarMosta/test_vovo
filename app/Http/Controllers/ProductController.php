<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with('category');

        if ($request->filled('q')) {
            $query->where('name', 'like', '%'.$request->q.'%');
        }

        if ($request->filled('price_from')) {
            $query->where('price', '>=', $request->price_from);
        }

        if ($request->filled('price_to')) {
            $query->where('price', '<=', $request->price_to);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('in_stock') && $request->in_stock !== '') {
            $query->where('in_stock', $request->in_stock === 'true');
        }

        if ($request->filled('rating_from')) {
            $query->where('rating', '>=', $request->rating_from);
        }

        $sortMap = [
            'price_asc' => ['price', 'asc'],
            'price_desc' => ['price', 'desc'],
            'rating_desc' => ['rating', 'desc'],
            'rating_asc' => ['rating', 'asc'],
            'newest' => ['created_at', 'desc'],
        ];

        $sort = $request->input('sort', 'newest');
        if (isset($sortMap[$sort])) {
            $query->orderBy(...$sortMap[$sort]);
        } else {
            $query->orderByDesc('created_at');
        }

        $products = $query->paginate(15)->withQueryString();
        $categories = Category::all();

        return view('admin.products.index', [
            'products' => $products,
            'categories' => $categories,
            'paginationView' => 'components::pagination',
        ]);
    }

    public function create(): View
    {
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'in_stock' => 'nullable|boolean',
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        if (! isset($validated['in_stock'])) {
            $validated['in_stock'] = false;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Товар создан');
    }

    public function edit(Product $product): View
    {
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'in_stock' => 'boolean',
            'rating' => 'numeric|min:0|max:5',
        ]);
        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Товар обновлён');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Товар удалён');
    }
}
