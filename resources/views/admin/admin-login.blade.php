<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Admin Login</title>
</head>

<body class="min-h-screen bg-gradient-to-r from-blue-950 via-blue-800 to-blue-600 flex items-center justify-center p-4">

    @error('email')
        <div
            class="mb-4 w-120 rounded-lg border border-white bg-white/40 px-4 py-3 text-white shadow-sm absolute top-10 right-10">
            {{ $message }}
        </div>
    @enderror
    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden grid md:grid-cols-2">

        <!-- Left Side -->
        <div
            class="hidden md:flex flex-col justify-center items-center bg-gradient-to-r from-blue-900 to-blue-700 text-white p-10">
            <div class="w-24 h-24 rounded-full bg-orange-500 flex items-center justify-center text-4xl shadow-xl">
                🔐
            </div>

            <h1 class="text-4xl font-bold mt-6">Admin Panel</h1>
            <p class="text-blue-100 mt-3 text-center">
                Secure access for administrators only.
            </p>
        </div>

        <!-- Right Side -->
        <div class="p-8 md:p-12">
            <h2 class="text-3xl font-bold text-blue-900">Admin Login</h2>
            <p class="text-gray-500 mt-2 mb-8">
                Sign in to manage dashboard
            </p>

            <form class="space-y-5" method="POST" action="login">
                @csrf
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        Admin Email
                    </label>
                    <input type="email" name="email" placeholder="admin@example.com"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-orange-300 focus:border-orange-500 outline-none" />
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <input type="password" name="password" placeholder="Enter password"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-orange-300 focus:border-orange-500 outline-none" />
                </div>

                <div class="flex justify-end">
                    <a href="#" class="text-sm text-orange-500 font-medium hover:underline">
                        Forgot Password?
                    </a>
                </div>

                <button
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-xl font-semibold shadow-lg transition">
                    Login as Admin
                </button>
            </form>
        </div>
    </div>

</body>

</html>
