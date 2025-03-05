<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaksi') }}
        </h2>
    </x-slot>
    <div class="bg-white rounded-lg flex flex-col justify-center w-[25%] shadow-lg p-6">
        <form action="{{ url('/save-barang') }}" method="POST" enctype="multipart/form-data">
            @csrf   
            <div class="mb-4">
                <label for="nama" class="block text-gray-700 font-bold mb-2">Nama Barang</label>
                <select name="nama" id="nama" class="w-full py-3 pl-5 border">
                    <option value="">Pilih nama barang</option>
                    {{-- @forelse($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @empty
                    @endforelse --}}
                </select>
            </div>
                {{-- <input type="text" name="nama" id="nama"
                    class="w-full px-3 py-2 border rounded-lg @error('nama') border-red-500 @enderror"
                    value="{{ old('nama') }}" required>
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror --}}

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="mb-4">
                    <label for="harga" class="block text-gray-700 font-bold mb-2">Harga Satuan</label>
                    <input type="number" name="harga" id="harga"
                        class="w-full px-3 py-2 border rounded-lg @error('harga') border-red-500 @enderror"
                        value="{{ old('harga') }}" required>
                    @error('harga')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="harga_grosir" class="block text-gray-700 font-bold mb-2">Harga Grosir</label>
                    <input type="number" name="harga_grosir" id="harga_grosir"
                        class="w-full px-3 py-2 border rounded-lg @error('harga_grosir') border-red-500 @enderror"
                        value="{{ old('harga_grosir') }}" required>
                    @error('harga_grosir')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="hpp" class="block text-gray-700 font-bold mb-2">Harga Modal</label>
                    <input type="number" name="hpp" id="hpp"
                        class="w-full px-3 py-2 border rounded-lg @error('hpp') border-red-500 @enderror"
                        value="{{ old('hpp') }}" required>
                    @error('hpp')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="supplier" class="block text-gray-700 font-bold mb-2">Supplier</label>
                <input type="text" name="supplier" id="supplier"
                    class="w-full px-3 py-2 border rounded-lg @error('supplier') border-red-500 @enderror"
                    value="{{ old('supplier') }}" required>
                @error('supplier')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-gray-700 font-bold mb-2">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4"
                    class="w-full px-3 py-2 border rounded-lg @error('deskripsi') border-red-500 @enderror" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Simpan
                </button>

            </div>
        </form>
    </div>
</x-app-layout>