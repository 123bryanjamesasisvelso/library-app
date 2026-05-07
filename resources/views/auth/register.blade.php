<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - {{ $roleLabel ?? 'Account' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center relative overflow-hidden bg-maroon-950">
    <div class="absolute inset-0">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[520px] h-[520px] opacity-20">
            <div class="w-full h-full bg-gradient-to-br from-maroon-600 to-gold-400 rounded-full blur-3xl"></div>
        </div>
        <div class="absolute top-20 left-20 w-64 h-64 bg-maroon-700/20 rounded-full blur-2xl"></div>
        <div class="absolute bottom-20 right-20 w-80 h-80 bg-gold-500/10 rounded-full blur-2xl"></div>
    </div>

    <div class="relative z-10 w-full max-w-md mx-4">
        <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl p-8 md:p-10">
            <div class="text-center mb-7">
                <div class="w-16 h-16 bg-maroon-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-maroon-200">
                    <svg class="w-9 h-9 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6H6zm7 1.5L18.5 9H13V3.5zM8 12h8v2H8v-2zm0 4h5v2H8v-2z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Create {{ $roleLabel ?? 'your' }} Account</h1>
                <p class="text-gray-500 mt-1">Join the library system in seconds</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <p class="font-semibold mb-2">Please fix the following:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.store', ['role' => $role]) }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-maroon-500 focus:border-transparent transition-all">
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-maroon-500 focus:border-transparent transition-all">
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-maroon-500 focus:border-transparent transition-all">
                    <p class="text-xs text-gray-400 mt-2">Minimum 8 characters.</p>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-maroon-500 focus:border-transparent transition-all">
                </div>

                <button type="submit"
                    class="w-full py-3.5 bg-maroon-600 text-white rounded-xl font-semibold hover:bg-maroon-700 transition-colors shadow-lg shadow-maroon-200 focus:outline-none focus:ring-2 focus:ring-maroon-500 focus:ring-offset-2">
                    Create Account
                </button>
            </form>

            <div class="text-center mt-6">
                <a href="{{ route('login') }}" class="text-sm text-maroon-700 hover:text-maroon-800 font-medium">Already have an account? Sign in</a>
            </div>
        </div>

        <div class="text-center mt-6">
            <a href="{{ url('/') }}" class="text-gray-400 hover:text-white text-sm transition-colors">&larr; Back to home</a>
        </div>
    </div>
</body>
</html>

