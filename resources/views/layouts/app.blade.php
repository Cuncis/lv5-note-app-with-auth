<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Notes') — Notes App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-yellow-50 text-gray-900 min-h-screen flex flex-col">

    <header class="bg-white border-b border-yellow-200 shadow-sm">
        <div class="max-w-3xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('notes.index') }}" class="text-lg font-bold text-yellow-600">
                🗒 Notes
            </a>

            {{-- Auth user info + logout --}}
            <div class="flex items-center gap-4 text-sm">
                <span class="text-gray-500 hidden sm:block">
                    👤 {{ auth()->user()->name }}
                </span>

                <a href="{{ route('notes.create') }}"
                    class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold px-4 py-1.5 rounded-lg transition text-sm">
                    + New Note
                </a>

                {{-- Logout form --}}
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-gray-400 hover:text-gray-600 transition">Log out</button>
                </form>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-3xl mx-auto w-full px-4 py-8">

        @if (session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-xl px-5 py-3 mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="text-center text-xs text-gray-400 py-6">
        &copy; {{ date('Y') }} Notes App — Laravel 12 + Breeze
    </footer>

</body>

</html>