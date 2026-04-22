@extends('layouts.app')
@section('title', 'Редактировать категорию')
@section('content')
    <h1>Редактировать категорию</h1>
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf @method('PUT')
        <div>
            <label>Название</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required>
        </div>
        <button class="btn" type="submit">Обновить</button>
    </form>
    <p><a href="{{ route('admin.categories.index') }}">← Назад</a></p>
@endsection
