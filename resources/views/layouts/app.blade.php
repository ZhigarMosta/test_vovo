<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin')</title>
    @vite(['resources/scss/main.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="container">
        <header>
            <span class="brand">Админка</span>
            <nav>
                <a href="{{ route('admin.products.index') }}">Товары</a>
                <a href="{{ route('admin.categories.index') }}">Категории</a>
            </nav>
        </header>
        <main>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>