<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog Produk Kami</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F4EFE6] antialiased">
    {{-- NAVBAR (Sama dengan Welcome) --}}
    <nav class="bg-[#4B5D3B] text-white py-4 px-6 md:px-12 flex justify-between items-center sticky top-0 z-50">
        <div class="text-xl font-bold">Produk Kami</div>
        <div class="flex items-center gap-8">
            <div class="hidden md:flex gap-6 text-sm">
                <a href="{{ route('home') }}" class="hover:text-amber-200">Home</a>
                <a href="{{ route('products.list') }}" class="text-amber-200">Produk</a>
            </div>
            <form action="{{ route('products.list') }}" method="GET">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." class="bg-white/10 border-none rounded-full py-1.5 px-4 text-xs focus:bg-white focus:text-gray-800 transition-all">
            </form>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-16 px-6 md:px-20">
        <h2 class="text-4xl font-bold text-[#7D5A44] mb-2 text-center">Daftar Produk</h2>
        <div class="w-20 h-1 bg-[#D35400] mx-auto mb-16 opacity-60"></div>

        {{-- GRID PRODUK --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
            @forelse($products as $product)
            {{-- CARD: Desain Rounded Persis image_fa9e37.png --}}
            <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col h-full border border-gray-100 hover:shadow-amber-900/10 transition duration-500">
                {{-- Gambar dengan Padding --}}
                <div class="h-64 p-5">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-[1.5rem] shadow-inner">
                </div>

                {{-- Detail Produk --}}
                <div class="px-8 pb-8 flex-grow">
                    <h3 class="font-bold text-2xl text-gray-800 mb-2">{{ $product->name }}</h3>
                    <p class="text-[#D35400] font-black text-xl mb-6">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                    
                    <div class="flex gap-4">
                        <a href="{{ route('product.show', $product) }}" class="flex-1 bg-[#4B5D3B] hover:bg-[#3a492e] text-white text-center py-3 rounded-xl font-bold text-sm shadow-lg transition">
                            Detail
                        </a>
                        @auth
                            {{-- Gunakan rute order.store yang sudah ada --}}
                            <form action="{{ route('order.store', $product) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" onclick="return confirm('Beli produk ini?')" class="w-full bg-[#D35400] hover:bg-[#E67E22] text-white text-center py-3 rounded-xl font-bold text-sm shadow-lg transition">
                                    Beli
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="flex-1 bg-[#D35400] hover:bg-[#E67E22] text-white text-center py-3 rounded-xl font-bold text-sm shadow-lg transition">
                                Lokasi
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            @empty
                <div class="col-span-full text-center py-20 bg-white/50 rounded-3xl border-2 border-dashed border-gray-300">
                    <p class="text-gray-500 italic text-lg">Maaf, produk yang kamu cari tidak ditemukan.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-16">
            {{ $products->links() }}
        </div>
    </div>
</body>
</html>