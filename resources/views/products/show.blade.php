<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} - Detail Produk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    
    <nav class="bg-white shadow mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-amber-700 font-bold text-xl">🏠 Produk Lokal</a>
                </div>
                <div class="flex items-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-amber-700 font-medium">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-amber-700 font-medium">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="/" class="inline-flex items-center mb-6 text-gray-500 hover:text-amber-700 transition">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda
            </a>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl flex flex-col md:flex-row">
                
                <div class="md:w-1/2 bg-gray-200">
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-96 md:h-[500px] object-cover">
                </div>
                
                <div class="p-8 md:p-12 md:w-1/2 flex flex-col justify-center">
                    <span class="text-amber-600 font-bold tracking-wider text-sm uppercase mb-2">Produk Unggulan</span>
                    <h1 class="text-4xl font-extrabold text-gray-900 mb-4">{{ $product->name }}</h1>
                    
                    <div class="text-3xl font-bold text-gray-800 mb-6 border-b pb-6 border-gray-100">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                    
                    <div class="prose text-gray-600 mb-8 leading-relaxed">
                        <p>{{ $product->description }}</p>
                    </div>

                    <div class="bg-amber-50 p-5 rounded-xl border border-amber-100 mb-8 flex items-start gap-4">
                        <div class="bg-amber-100 p-2 rounded-full text-amber-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-sm uppercase">Lokasi Produksi</h3>
                            <p class="text-gray-600 mt-1">{{ $product->production_address }}</p>
                            <a href="{{ $product->maps_link }}" target="_blank" class="text-amber-700 hover:text-amber-900 font-bold text-sm flex items-center mt-2 group">
                                Buka di Google Maps 
                                <span class="group-hover:translate-x-1 transition-transform ml-1">→</span>
                            </a>
                        </div>
                    </div>

                    <div class="mt-auto">
                        @auth
                            <form action="{{ route('order.store', $product) }}" method="POST">
                                @csrf
                                <button onclick="return confirm('Apakah Anda yakin ingin memesan produk ini?')" class="w-full bg-gray-900 hover:bg-gray-800 text-white font-bold py-4 px-6 rounded-xl transition shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    🛒 Beli Sekarang
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="block w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-4 px-6 rounded-xl transition">
                                🔒 Login untuk Membeli
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>