<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Generator Promosi Otomatis</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('post.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Pilih Produk</label>
                            <select name="product_id" class="w-full border rounded p-2 bg-white" required>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Target Market</label>
                            <input type="text" name="target_market" placeholder="Misal: Mahasiswa, Ibu-ibu" class="w-full border rounded p-2" required>
                        </div>
                    </div>
                    <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">✨ Generate Kata-kata Promosi</button>
                </form>

                @if(session('generated_post'))
                <div class="mt-8 border-t pt-6">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <h3 class="font-bold text-green-800 mb-2">Hasil Generate:</h3>
                        <textarea id="promoText" rows="4" class="w-full p-3 border rounded-lg bg-white text-gray-800 focus:ring-0" readonly>{{ session('generated_post')->content }}</textarea>
                        
                        <div class="mt-4 flex flex-wrap gap-2">
                            <button onclick="copyText()" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900">📋 Copy Text</button>
                            
                            <a href="https://wa.me/?text={{ urlencode(session('generated_post')->content) }}" target="_blank" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">WhatsApp</a>
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode(session('generated_post')->content) }}" target="_blank" class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800">Twitter / X</a>
                        </div>
                    </div>
                </div>

                <script>
                function copyText() {
                    var copyText = document.getElementById("promoText");
                    copyText.select();
                    document.execCommand("copy");
                    alert("Teks berhasil disalin!");
                }
                </script>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>