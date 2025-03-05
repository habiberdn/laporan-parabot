<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pencarian Barang') }}
        </h2>
    </x-slot>
    <section class="grid grid-cols-4 w-[90%]  gap-4">
        <section class="grid grid-cols-4 col-span-3 p-4">
            @if (isset($barangs))
                @forelse($barangs as $my_product)
                    <a href="{{ route('barang.edit', $my_product->id) }}"
                        class="item-product bg-white flex flex-row justify-center items-center rounded-xl p-2 w-[10rem] h-[12rem]">
                        <div class="flex flex-col items-center  justify-center">
                            @if ($my_product->image && Storage::disk('public')->exists($my_product->image))
                                <img src="{{ asset('storage/' . $my_product->image) }}"
                                    class="rounded-2xl h-[100px] w-auto" alt="{{ $my_product->nama }}">
                            @else
                                <div
                                    class="rounded-2xl h-[100px] w-[100px] bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">No image</span>
                                </div>
                            @endif
                            <div class="flex flex-col ">
                                <h3 class="text-indigo-950 font-bold text-xl">{{ $my_product->nama }}</h3>
                                <p class="text-slate-500 text-sm text-center">
                                    {{ number_format($my_product->harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="col-span-4 text-center text-gray-500">Belum ada produk tersedia</p>
                @endforelse
            @else
                <p class="col-span-4 text-center text-gray-500">Variable barang is not set</p>
            @endif
        </section>

</x-app-layout>