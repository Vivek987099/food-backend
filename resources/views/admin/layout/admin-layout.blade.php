<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token"  content="{{ csrf_token() }}" >
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/cfea9fe99d.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- sidebar -->
    <aside class="fixed left-0 top-0 h-screen w-72 bg-[#111827] border-r border-gray-800">

        <!-- Logo -->
        <div class="border-b border-gray-800 px-6 py-5">
            <h1 class="text-2xl font-bold text-white">
                Food<span class="text-orange-400">Admin</span>
            </h1>
        </div>

        <!-- Sidebar Menu -->
        <nav class="p-4 space-y-3">
            <a href="/admin/dashboard"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-gray-300 hover:bg-gray-800">
                📊 Dashboard
            </a>

            <a href="/admin/category"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-gray-300 hover:bg-gray-800">
                📂 Category
            </a>

            <a href="/admin/foods" class="flex items-center gap-3 rounded-xl px-4 py-3 text-gray-300 hover:bg-gray-800">
                🍔 Food Items
            </a>
            <a href="/admin/orders"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-gray-300 hover:bg-gray-800">
                <i class="fa-solid fa-bag-shopping text-white"></i> Orders
            </a>
            <a href="/admin/sliders"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-gray-300 hover:bg-gray-800">
                <i class="fa-solid fa-images"></i> Slider
            </a>
            <a href="/admin/users" class="flex items-center gap-3 rounded-xl px-4 py-3 text-gray-300 hover:bg-gray-800">
                <i class="fa-regular fa-user"></i> Users
            </a>
        </nav>

        <!-- Bottom Auth Section -->
        <div class="absolute bottom-0 w-full border-t border-gray-800 p-5">

            @auth
                <div class="mb-4 flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-500 text-white font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-white">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-xs text-gray-400">
                            {{ auth()->user()->email }}
                        </p>
                    </div>
                </div>

                <form action="/admin/logout" method="POST">
                    @csrf
                    <button class="w-full rounded-lg bg-red-500 px-4 py-2 text-white hover:bg-red-600">
                        Logout
                    </button>
                </form>
            @endauth

            @guest
                <a href="/admin/login"
                    class="block w-full rounded-lg bg-orange-500 px-4 py-3 text-center font-medium text-white hover:bg-orange-600">
                    Login
                </a>
            @endguest

        </div>
    </aside>

    <!-- header -->
    <!-- Top Bar -->
    <header
        class="fixed top-0 right-0 left-72 z-50 flex items-center justify-between border-b border-gray-800 bg-[#0f172a] px-8 py-4">

        <!-- Left -->
        <div>
            <h1 class="text-2xl font-bold text-white">Dashboard</h1>
            <p class="text-sm text-gray-400">Welcome back, Admin 👋</p>
        </div>

        <!-- Right -->
        <div class="flex items-center gap-4">

            <!-- Search -->
            <div class="relative">
                <input type="text" placeholder="Search food..."
                    class="w-72 rounded-xl border border-gray-700 bg-[#1f2937] py-2 pl-4 pr-10 text-white outline-none focus:border-orange-400" />
                <span class="absolute right-3 top-2.5 text-gray-400">🔍</span>
            </div>

            <!-- Add Food Button -->
            <a href="{{ route('foods.add') }}" class="rounded-xl bg-orange-500 px-4 py-2 font-medium text-white transition hover:bg-orange-600">
                + Add Food
            </a>

            <!-- Notification -->
            <button class="relative rounded-full bg-[#1f2937] p-3 text-white hover:bg-gray-700">
                🔔
                <span class="absolute right-1 top-1 h-2 w-2 rounded-full bg-red-500"></span>
            </button>

            <!-- Profile -->
            <div class="flex items-center gap-3 rounded-xl bg-[#1f2937] px-3 py-2">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-500 font-bold text-white">
                    A
                </div>

                <div>
                    <p class="text-sm font-semibold text-white">Admin</p>
                    <p class="text-xs text-gray-400">Super Admin</p>
                </div>
            </div>

        </div>
    </header>

    <main class="ml-72 bg-[#0f172a] min-h-screen mt-20">
        @yield('content')
    </main>
</body>

@stack('script')

</html>
