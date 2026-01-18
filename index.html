<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Produk Lokal Indonesia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 antialiased">
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 sm:items-center py-4 sm:pt-0">
        @if (Route::has('login'))
            <div class="fixed top-0 right-0 px-6 py-4 sm:block z-50">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-full mt-16">
            <div class="text-center mb-10">
                <h1 class="text-4xl font-extrabold text-amber-800">Dukung Produk Lokal 🇮🇩</h1>
                <p class="mt-2 text-gray-600">Temukan karya terbaik anak bangsa di sekitarmu.</p>
                
                <form action="{{ route('home') }}" method="GET" class="mt-6 flex justify-center gap-2">
                    <input type="text" name="search" placeholder="Cari keripik, batik, kopi..." value="{{ request('search') }}" class="rounded-lg border-gray-300 p-2 w-full md:w-1/3 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                    <button type="submit" class="bg-amber-700 hover:bg-amber-800 text-white px-6 py-2 rounded-lg transition">Cari</button>
                </form>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-center">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-center">{{ session('error') }}</div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                @forelse($products as $product)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    <div class="p-5">
                        <h3 class="font-bold text-xl text-gray-800 mb-1">{{ $product->name }}</h3>
                        <p class="text-amber-600 font-bold text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ $product->description }}</p>
                        
                        <div class="mt-4 flex justify-between items-center pt-4 border-t border-gray-100">
                            <a href="{{ route('product.show', $product) }}" class="text-gray-600 hover:text-amber-700 text-sm font-medium">Detail & Lokasi</a>
                            
                            @auth
                                <form action="{{ route('order.store', $product) }}" method="POST">
                                    @csrf
                                    <button onclick="return confirm('Beli produk ini?')" class="bg-green-600 hover:bg-green-700 text-white px-4 py-1.5 rounded-lg text-sm transition">Beli Sekarang</button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400 italic">Login untuk beli</span>
                            @endauth
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-10 text-gray-500">
                    Belum ada produk lokal yang ditemukan. Jadilah yang pertama!
                </div>
                @endforelse
            </div>
            
            <div class="mb-10">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</body>
</html>