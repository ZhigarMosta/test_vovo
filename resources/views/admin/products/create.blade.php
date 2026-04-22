@extends('layouts.app')
@section('title', 'Добавить товар')
@section('content')
    <h1>Добавить товар</h1>
    <form action="{{ route('admin.products.store') }}" method="POST">
        @csrf
        <div>
            <label>Название</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>
        <div>
            <label>Категория</label>
            <select name="category_id" required>
                <option value="">-- Выберите --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Цена</label>
            <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" required>
        </div>
        <div>
            <label>Рейтинг (0-5)</label>
            <input type="number" name="rating" value="{{ old('rating', 0) }}" step="0.1" min="0" max="5">
        </div>
        <div>
            <label><input type="checkbox" name="in_stock" value="1" {{ old('in_stock') ? 'checked' : '' }}> В наличии</label>
        </div>
        <button class="btn" type="submit">Создать</button>
    </form>
    <p><a href="{{ route('admin.products.index') }}">← Назад</a></p>
@endsection
