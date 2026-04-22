@extends('layouts.app')
@section('title', 'Товары')
@section('content')
    <div class="page-header">
        <h1>Товары</h1>
    </div>

    <form method="GET" action="{{ route('admin.products.index') }}" class="filter-form">
        <div class="filter-grid">
            <div class="form-group">
                <label>Поиск</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Поиск...">
            </div>
            <div class="form-group">
                <label>Категория</label>
                <select name="category_id">
                    <option value="">Все</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Цена от</label>
                <input type="number" name="price_from" value="{{ request('price_from') }}" step="0.01">
            </div>
            <div class="form-group">
                <label>Цена до</label>
                <input type="number" name="price_to" value="{{ request('price_to') }}" step="0.01">
            </div>
            <div class="form-group">
                <label>Рейтинг от</label>
                <input type="number" name="rating_from" value="{{ request('rating_from') }}" step="0.1" min="0" max="5">
            </div>
            <div class="form-group">
                <label>В наличии</label>
                <select name="in_stock">
                    <option value="">Все</option>
                    <option value="true" {{ request('in_stock') === 'true' ? 'selected' : '' }}>Да</option>
                    <option value="false" {{ request('in_stock') === 'false' ? 'selected' : '' }}>Нет</option>
                </select>
            </div>
            <div class="form-group">
                <label>Сортировка</label>
                <select name="sort">
                    <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Новые</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Цена ↑</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Цена ↓</option>
                    <option value="rating_asc" {{ request('sort') === 'rating_desc' ? 'selected' : '' }}>Рейтинг ↓</option>
                    <option value="rating_desc" {{ request('sort') === 'rating_asc' ? 'selected' : '' }}>Рейтинг ↑</option>
                </select>
            </div>
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">Применить</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-clean-query">Сбросить</a>
            </div>
        </div>
    </form>

    <div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Добавить товар</a>
    </div>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Категория</th>
            <th>Цена</th>
            <th>В наличии</th>
            <th>Рейтинг</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @forelse($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name ?? '-' }}</td>
                <td>{{ number_format($product->price, 2) }} ₽</td>
                <td>
                    @if($product->in_stock)
                        <span class="badge badge-success">Да</span>
                    @else
                        <span class="badge badge-danger">Нет</span>
                    @endif
                </td>
                <td>{{ $product->rating ?? '-' }}/5</td>
                <td class="actions">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary btn-sm">Редактировать</a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Удалить?')">Удалить</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">Нет товаров</td>
            </tr>
        @endforelse
</tbody>
    </table>
    @if($products->hasPages())
        @include('components::pagination', ['paginator' => $products])
    @endif
@endsection
