@extends('layouts.app')

@section('content')
<div class="mb-6 border-b border-gray-200">
    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
        <li class="mr-2">
            <a href="{{ route('barang.create') }}"
                class="inline-block p-4 border-b-2 rounded-t-lg {{ request()->is('barang/create') ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-600' }}">
                Tambah Barang
            </a>
        </li>
        <li class="mr-2">
            <a href=""
                class="inline-block p-4 border-b-2 rounded-t-lg {{ request()->is('barang/tambah-stok') ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-600' }}">
                Tambah Stok
            </a>
        </li>
    </ul>
</div>

<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-semibold mb-4">Update Stok Barang</h1>

    <!-- Form update barang -->
    <form action="{{ route('barang.updateStok') }}" method="POST" class="space-y-6">
        @csrf
        <!-- Nama Barang -->
        <div class="mb-2 relative">
            <label for="nama_Barang" class="block text-sm font-medium text-gray-700">Nama Barang</label>
            <input type="text" id="nama_Barang" name="nama_Barang" value="{{ old('nama_Barang') }}"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required autocomplete="off" 
                data-barang="{{ json_encode($barang) }}">
            <ul id="namaSuggestions" class="absolute z-10 bg-white border border-gray-300 rounded-md shadow-md w-full hidden">
                @foreach ($barang as $item)
                    <li class="px-3 py-2 hover:bg-gray-200 cursor-pointer" data-satuan="{{ $item->satuan }}">{{ $item->nama_Barang }}</li>
                @endforeach
            </ul>
            @error('nama_Barang')
            <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Satuan -->
        <div class="mb-2">
            <label for="satuan" class="block text-sm font-medium text-gray-700">Satuan</label>
            <input type="text" name="satuan" id="satuan" value="{{ old('satuan') }}" readonly
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required readonly>
            @error('satuan')
            <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Stok -->
        <div class="mb-2">
            <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
            <input type="number" name="stok" value="{{ old('stok') }}"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            @error('stok')
            <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Button Simpan -->
        <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Simpan</button>
    </form>
</div>

<script>
    // Menyimpan data barang yang terdapat dalam atribut data-barang
    const barangData = JSON.parse(document.getElementById('nama_Barang').getAttribute('data-barang'));

    // Menambahkan event listener untuk input nama barang
    document.getElementById('nama_Barang').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const suggestions = document.getElementById('namaSuggestions');
        const items = suggestions.querySelectorAll('li');

        // Menyembunyikan semua item yang tidak cocok dengan input
        let found = false;
        items.forEach(item => {
            if (item.textContent.toLowerCase().includes(query)) {
                item.classList.remove('hidden');
                found = true;
            } else {
                item.classList.add('hidden');
            }
        });

        // Menampilkan atau menyembunyikan daftar saran
        if (found) {
            suggestions.classList.remove('hidden');
        } else {
            suggestions.classList.add('hidden');
        }
    });

    // Menambahkan event listener untuk klik pada item saran
    document.getElementById('nama_Barang').addEventListener('input', function() {
        const items = document.querySelectorAll('#namaSuggestions li');
        items.forEach(function(item) {
            item.addEventListener('click', function() {
                document.getElementById('nama_Barang').value = item.textContent;
                const satuan = item.getAttribute('data-satuan');
                document.getElementById('satuan').value = satuan; // Mengisi nilai satuan
                document.getElementById('namaSuggestions').classList.add('hidden');
            });
        });
    });

    // Menambahkan event listener untuk klik di luar input atau daftar saran
    document.addEventListener('click', function(e) {
        const suggestions = document.getElementById('namaSuggestions');
        const input = document.getElementById('nama_Barang');
        if (!input.contains(e.target) && !suggestions.contains(e.target)) {
            suggestions.classList.add('hidden');
        }
    });
</script>

@endsection
