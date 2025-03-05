<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Barang') }}
        </h2>
    </x-slot>

    <div class="p-6 flex flex-col">

        <form action="{{ route('search') }}" method="GET" class="flex gap-4 items-center">
            <label for="search">Cari</label>
            <input type="text" name="search" id="search" class="rounded-xl border border-none"
                placeholder="Cari barang">
        </form>
            <section class="
             flex justify-between gap-4">
                <section
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 col-span-1 md:col-span-2 lg:col-span-3 p-5 gap-4 md:gap-8 ">
                    @if (isset($my_products))
                        @forelse($my_products as $my_product)
                            <a href="{{ route('barang.edit', $my_product->id) }}"
                                class="item-product bg-white flex flex-col rounded-xl p-2 w-full sm:w-[10rem] h-[12rem] mx-auto overflow-hidden">
                                <div class="flex flex-col h-full w-full">
                                    @if ($my_product->image && Storage::disk('public')->exists($my_product->image))
                                        <div class="h-[70%] w-[100%] ">
                                            <img src="{{ asset('storage/' . $my_product->image) }}"
                                                class="rounded-2xl w-[100%] h-full  object-cover"
                                                alt="{{ $my_product->nama }}">
                                        </div>
                                    @else
                                        <div
                                            class="h-[60%] w-full rounded-2xl bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-500">No image</span>
                                        </div>
                                    @endif
                                    <div class="flex flex-col justify-center flex-grow">
                                        <h3
                                            class="text-indigo-950 font-bold text-lg sm:text-xl break-words text-center">
                                            {{ $my_product->nama }}</h3>
                                        <p class="text-slate-500 text-sm text-center">
                                            Rp {{ number_format($my_product->harga, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="col-span-1 sm:col-span-2 md:col-span-3 lg:col-span-5 text-center text-gray-500">
                                Belum ada produk tersedia</p>
                        @endforelse
                    @else
                        <p class="col-span-1 sm:col-span-2 md:col-span-3 lg:col-span-5 text-center text-gray-500">
                            Variable my_products is not set</p>
                    @endif
                </section>

                <section class="p-4 col-span-1">
                    <button onclick="window.location='{{ route('barang.add') }}'"
                        class="bg-black text-white p-3 rounded-xl w-full sm:w-auto">
                        Tambah Barang
                    </button>
                </section>
            </section>
    </div>

</x-app-layout>
