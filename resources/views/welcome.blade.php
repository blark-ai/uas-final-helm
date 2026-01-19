<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selamat Datang - Produk Lokal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F4EFE6] antialiased">
    {{-- NAVBAR --}}
    <nav class="bg-[#4B5D3B] text-white py-4 px-6 md:px-12 flex justify-between items-center sticky top-0 z-50 shadow-md">
        <div class="text-xl font-bold">LokalID</div>
        <div class="flex items-center gap-8">
            <div class="hidden md:flex gap-6 text-sm font-medium">
                <a href="{{ route('home') }}" class="text-amber-200">Home</a>
                <a href="{{ route('products.list') }}" class="hover:text-amber-200">Produk</a>
                @auth <a href="{{ url('/dashboard') }}" class="hover:text-amber-200">Dashboard</a> @endauth
            </div>
            {{-- Search Bar di Navbar --}}
            <form action="{{ route('products.list') }}" method="GET" class="relative">
                <input type="text" name="search" placeholder="Cari produk..." class="bg-white/10 border-none rounded-full py-1.5 px-4 text-xs focus:bg-white focus:text-gray-800 focus:ring-2 focus:ring-amber-500 transition-all w-32 md:w-48">
            </form>
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <section class="bg-[#7D5A44] min-h-[80-vh] flex items-center justify-center py-32 px-6 text-center text-white relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 drop-shadow-lg uppercase tracking-tighter">Dukung Produk Lokal</h1>
            <p class="text-xl md:text-2xl mb-12 opacity-90 font-light max-w-2xl mx-auto">Temukan kebanggaan karya terbaik anak bangsa langsung dari daerahmu.</p>
            <a href="{{ route('products.list') }}" class="bg-[#D35400] hover:bg-[#E67E22] text-white font-bold py-4 px-12 rounded-xl shadow-2xl transition transform hover:scale-105 inline-block text-lg">
                Lihat Produk
            </a>
        </div>
        {{-- Dekorasi Daun --}}
        <div class="absolute -bottom-20 -left-20 opacity-10 w-80 rotate-45">
            <img src="https://cdn-icons-png.flaticon.com/512/892/892926.png" alt="leaf">
        </div>
    </section>

    <footer class="bg-[#4B5D3B] py-8 text-center text-white/50 text-sm">
        <p>&copy; 2026 LokalID. Bangga Buatan Indonesia.</p>
    </footer>
</body>
</html>