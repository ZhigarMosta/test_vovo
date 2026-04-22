@extends('layouts.app')
@section('title', 'Категории')
@section('content')
    <div class="page-header">
        <h1>Категории</h1>
    </div>

    <form method="GET" action="{{ route('admin.categories.index') }}" class="filter-form">
        <div class="filter-grid">
            <div class="form-group">
                <label>Поиск</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Поиск...">
            </div>
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">Применить</button>
                <a href="{{ route('admin.categories.index') }}" class="btn">Сбросить</a>
            </div>
        </div>
    </form>

    <div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ Добавить категорию</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Товаров</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->products_count }}</td>
                    <td class="actions">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary btn-sm">Редактировать</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Удалить?')">Удалить</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">Нет категорий</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($categories->hasPages())
        @include('components::pagination', ['paginator' => $categories])
    @endif
@endsection
