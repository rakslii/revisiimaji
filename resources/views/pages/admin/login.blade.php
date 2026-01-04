<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-2xl font-bold text-center mb-6">
            Admin Login
        </h1>

        {{-- error --}}
        @if ($errors->any())
            <div class="mb-4 text-sm text-red-600">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Email</label>
                <input
                    type="email"
                    name="email"
                    required
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-black"
                >
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-1">Password</label>
                <input
                    type="password"
                    name="password"
                    required
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-black"
                >
            </div>

            <button
                type="submit"
                class="w-full bg-black text-white py-2 rounded-lg hover:bg-gray-800 transition"
            >
                Login
            </button>
        </form>
    </div>

</body>
</html>
