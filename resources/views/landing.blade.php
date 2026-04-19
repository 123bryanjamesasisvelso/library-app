<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Library Management</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen relative">
    <div class="fixed inset-0 -z-10" style="background-image: url('{{ asset('images/libraryngani.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/40 to-black/60"></div>
    </div>
    <nav class="bg-white/10 backdrop-blur-md border-b border-white/10 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6H6zm7 1.5L18.5 9H13V3.5zM8 12h8v2H8v-2zm0 4h5v2H8v-2z"/>
                    </svg>
                </div>
                <span class="text-xl font-bold text-white">DigiLib</span>
            </div>
            <div class="hidden md:flex items-center gap-8">
                <a href="#" class="text-white/80 hover:text-white transition-colors font-medium">Features</a>
                <a href="#" class="text-white/80 hover:text-white transition-colors font-medium">About</a>
                <a href="#" class="text-white/80 hover:text-white transition-colors font-medium">Contact</a>
                <a href="{{ url('/login') }}" class="px-5 py-2.5 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors font-medium shadow-lg shadow-purple-900/30">Sign In</a>
            </div>
            <button class="md:hidden text-gray-600" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
        <div id="mobile-menu" class="hidden md:hidden px-6 pb-4 space-y-3">
            <a href="#" class="block text-white/80 hover:text-white font-medium">Features</a>
            <a href="#" class="block text-white/80 hover:text-white font-medium">About</a>
            <a href="#" class="block text-white/80 hover:text-white font-medium">Contact</a>
            <a href="{{ url('/login') }}" class="block px-5 py-2.5 bg-purple-600 text-white rounded-xl text-center font-medium">Sign In</a>
        </div>
    </nav>

    <section class="relative overflow-hidden">
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-500/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-purple-400/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-purple-300/10 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 py-24 md:py-36 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="flex-1 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 text-white rounded-full text-sm font-medium mb-6 border border-white/10">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        Modern Library Solution
                    </div>
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-white leading-tight mb-6">
                        Digital Library<br>
                        <span class="text-purple-300">Management</span>
                    </h1>
                    <p class="text-lg md:text-xl text-white/80 max-w-xl mb-8 leading-relaxed">
                        Transform your library experience with powerful tools for tracking books, managing borrowing, and streamlining operations — all in one efficient, user-friendly platform.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ url('/login') }}" class="px-8 py-4 bg-purple-600 text-white rounded-2xl hover:bg-purple-700 transition-all font-semibold text-lg shadow-xl shadow-purple-900/30 hover:shadow-purple-900/40 hover:-translate-y-0.5">
                            Get Started
                        </a>
                        <a href="#" class="px-8 py-4 bg-white/10 text-white rounded-2xl border border-white/20 hover:border-white/40 transition-all font-semibold text-lg hover:-translate-y-0.5 backdrop-blur">
                            Learn More
                        </a>
                    </div>
                </div>

                <div class="flex-1 flex justify-center">
                    <div class="relative">
                        <div class="w-80 h-80 md:w-96 md:h-96 bg-gradient-to-br from-purple-500 to-purple-700 rounded-full flex items-center justify-center shadow-2xl shadow-purple-300/50">
                            <svg class="w-40 h-40 md:w-48 md:h-48 text-white/90" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M21 4H3a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1zM4 18V6h7v12H4zm9 0V6h7v12h-7z"/>
                                <path d="M6 8h3v2H6V8zm0 4h3v2H6v-2zm0 4h3v2H6v-2zm9-8h3v2h-3V8zm0 4h3v2h-3v-2zm0 4h3v2h-3v-2z"/>
                            </svg>
                        </div>
                        <div class="absolute -top-4 -right-4 w-20 h-20 bg-purple-300/40 rounded-full blur-lg animate-pulse"></div>
                        <div class="absolute -bottom-6 -left-6 w-24 h-24 bg-purple-400/30 rounded-full blur-lg animate-pulse" style="animation-delay: 1s"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Why Choose DigiLib?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">Everything you need to manage your library efficiently and provide an exceptional experience for your patrons.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-purple-50 rounded-2xl p-8 hover:shadow-lg transition-shadow">
                    <div class="w-14 h-14 bg-purple-600 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Book Tracking</h3>
                    <p class="text-gray-600 leading-relaxed">Effortlessly track your entire collection with real-time inventory management and detailed cataloging tools.</p>
                </div>
                <div class="bg-purple-50 rounded-2xl p-8 hover:shadow-lg transition-shadow">
                    <div class="w-14 h-14 bg-purple-600 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Borrowing Management</h3>
                    <p class="text-gray-600 leading-relaxed">Streamline check-ins, check-outs, and returns with automated tracking and overdue notifications.</p>
                </div>
                <div class="bg-purple-50 rounded-2xl p-8 hover:shadow-lg transition-shadow">
                    <div class="w-14 h-14 bg-purple-600 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Analytics & Reports</h3>
                    <p class="text-gray-600 leading-relaxed">Gain insights into library usage patterns, popular titles, and operational efficiency with detailed analytics.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6H6zm7 1.5L18.5 9H13V3.5zM8 12h8v2H8v-2zm0 4h5v2H8v-2z"/>
                        </svg>
                    </div>
                    <span class="text-white font-bold">DigiLib</span>
                </div>
                <p class="text-sm">&copy; 2026 Digital Library Management. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
