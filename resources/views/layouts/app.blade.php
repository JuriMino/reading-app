<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '読書記録') | Reading Record</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen">
    <header class="bg-white shadow-sm">
        <div class="max-w-full mx-auto px-10 py-4">
            <a href="{{route('books.index')}}" class="text-xl font-bold text-blue-600">
                Reading Record
            </a>
        </div>
    </header>
    <main class="max-w-full mx-auto px-10 py-8">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-md">
                {{session('success')}}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
