<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Produk Saya') }}
            </h2>
            <div class="flex items-center gap-4">
                {{-- TOMBOL KEMBALI KE WELCOME PAGE --}}
                <a href="{{ url('/') }}" class="hidden md:block text-sm text-amber-700 hover:text-amber-900 font-bold underline">
                    🏠 Lihat Beranda
                </a>
                <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                    Total: {{ $products->count() }} Produk
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 flex flex-col md:flex-row gap-4 justify-between items-center">
                <div class="flex flex-wrap gap-3 w-full md:w-auto">
                    {{-- TOMBOL LIHAT BERANDA (VERSI MOBILE & DESKTOP) --}}
                    <a href="{{ url('/') }}" class="flex-1 md:flex-none text-center bg-gray-800 hover:bg-black text-white font-bold py-3 px-6 rounded-lg shadow-md transition transform hover:-translate-y-1">
                        🏠 Beranda
                    </a>

                    <a href="{{ route('products.create') }}" class="flex-1 md:flex-none text-center bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition transform hover:-translate-y-1">
                        + Tambah Produk
                    </a>

                    <a href="{{ route('post.create') }}" class="flex-1 md:flex-none text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition transform hover:-translate-y-1">
                        ✨ Generate Promosi
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r shadow-sm flex justify-between items-center">
                    <p>{{ session('success') }}</p>
                    <button onclick="this.parentElement.style.display='none'" class="text-green-700 font-bold">&times;</button>
                </div>
            @endif

            @if($products->isEmpty())
                <div class="bg-white rounded-xl shadow-sm p-12 text-center border-2 border-dashed border-gray-300">
                    <div class="text-gray-400 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada produk</h3>
                    <p class="mt-1 text-gray-500">Mulai dengan menambahkan produk jualanmu sekarang.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition duration-300 border border-gray-100 overflow-hidden flex flex-col h-full">
                        
                        <div class="relative h-48 bg-gray-200">
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                            <div class="absolute top-2 right-2 bg-white/90 backdrop-blur px-2 py-1 rounded text-xs font-bold text-amber-700 shadow">
                                ID: {{ $product->id }}
                            </div>
                        </div>

                        <div class="p-5 flex-grow">
                            <h3 class="font-bold text-lg text-gray-900 leading-tight mb-1">{{ $product->name }}</h3>
                            <p class="text-amber-600 font-bold text-lg mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            
                            <p class="text-gray-500 text-sm line-clamp-2 mb-4">
                                {{ $product->description }}
                            </p>
                            
                            <div class="flex items-center text-xs text-gray-400 gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="truncate">{{ $product->production_address }}</span>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-5 py-4 border-t border-gray-100 flex justify-between items-center gap-2">
                            <a href="{{ route('products.edit', $product) }}" class="flex-1 bg-white border border-gray-300 text-gray-700 font-semibold py-2 px-4 rounded hover:bg-gray-50 hover:text-blue-600 transition text-center text-sm">
                                ✏️ Edit
                            </a>

                            <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin hapus produk {{ $product->name }}?');" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-50 border border-red-100 text-red-600 font-semibold py-2 px-4 rounded hover:bg-red-100 transition text-center text-sm">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-8 text-center text-gray-400 text-sm">
                    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Dibuat dengan Laravel & ❤️</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>