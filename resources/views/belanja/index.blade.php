<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Belanja') }}
        </h2>
    </x-slot>
    <section class=" p-3 sm:p-5">
        <div class="flex flex-col gap-4 px-4 lg:px-12">

            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center" method="GET">
                            @csrf
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" name="search" id="simple-search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Search products..." value="{{ request('search') }}">
                            </div>
                        </form>
                    </div>
                    <div
                        class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">

                        <!-- Stock Filter Dropdown -->
                        <form method="GET" action="{{ route('belanja') }}" class="flex gap-2">
    <!-- Filter Stok -->
    <select name="stok" onchange="submitForm()" 
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <option value="">Semua Stok</option> <!-- Ubah value default ke string kosong -->
        <option value="ada" {{ request('stok') === 'ada' ? 'selected' : '' }}>Stok Ada</option>
        <option value="kosong" {{ request('stok') === 'kosong' ? 'selected' : '' }}>Stok Kosong</option>
    </select>

    <!-- Filter Pemasok -->
    <select name="pemasok" onchange="submitForm()"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <option value="">Semua Pemasok</option>
        @foreach ($pemasokList as $pemasok)
            <option value="{{ $pemasok }}" {{ request('pemasok') == $pemasok ? 'selected' : '' }}>
                {{ $pemasok }}
            </option>
        @endforeach
    </select>

    <!-- Tambahkan ini jika ada input pencarian -->
 
</form>
                        <button x-data="" x-on:click="$dispatch('open-modal', 'default-modal')"
                            class="block h-[3rem] w-[10rem] text-white bg-[#00008B] hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl px-3 py-2.5 text-center dark:bg-[#00008B] dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="button">
                            Reset Stok
                        </button>
                    </div>
                </div>

                <!-- Main modal -->
                <div x-data="{ show: false }"
                    x-on:open-modal.window="$event.detail == 'default-modal' ? show = true : null"
                    x-on:close-modal.window="show = false" x-on:keydown.escape.window="show = false" x-show="show"
                    x-transition x-trap.noscroll.inert="show" class="fixed inset-0 z-50 overflow-y-auto"
                    style="display: none;" tabindex="-1" aria-hidden="true">

                    <!-- Overlay -->
                    <div x-on:click="show = false" class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity">
                    </div>

                    <div class="flex items-center justify-center min-h-screen p-4">
                        <div x-on:click.stop class="relative p-4 w-full max-w-2xl max-h-full">

                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                <!-- Modal header -->
                                <div
                                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                        {{ __('Reset Stok') }}
                                    </h3>
                                    <button type="button" x-on:click="show = false"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                        <span class="sr-only">{{ __('Close modal') }}</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-4 md:p-5 space-y-4">
                                    <p class="text-base leading-relaxed text-white ">
                                        Yakin Reset Stok?
                                    </p>
                                </div>
                                <!-- Modal footer -->
                                <div
                                    class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                    <form method="POST" action="{{ route('belanja.reset') }}" id="resetForm">
                                        @csrf
                                        @method('POST')
                                        <button type="submit"
                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            {{ __('Ya') }}
                                        </button>
                                    </form>
                                    <button x-on:click="show = false" type="button"
                                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                        {{ __('Tidak') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class=" text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-center">No</th>
                                <th scope="col" class="px-4 py-3 text-center">Nama Barang</th>
                                <th scope="col" class="px-4 py-3 text-center">Jumlah Pesanan</th>
                                <th scope="col" class="px-4 py-3 text-center">Satuan</th>
                                <th scope="col" class="px-4 py-3 text-center">Stok Barang</th>
                                <th scope="col" class="px-4 py-3 text-center">Pemasok</th>
                                <th scope="col" class="px-4 py-3 text-center">Gambar</th>
                                <th scope="col" class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($belanja as $product)
                                <tr class="border-b dark:border-gray-700">

                                    <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 text-center">{{ $product->nama_barang }}</td>
                                    <td class="px-4 py-3 text-center">{{ $product->jumlah_pesanan }}</td>
                                    <td class="px-4 py-3 text-center">{{ number_format($product->satuan) }}</td>
                                    <td class="px-4 py-3 text-center">{{ $product->stok }}</td>
                                    <td class="px-4 py-3 text-center">{{ $product->pemasok }}</td>
                                    <td class="px-4 py-3 flex justify-center">
                                        <img src="{{ asset('storage/' . $product->gambar) }}"alt="" class='w-20'>
                                    </td>
                                    <td class="px-4 py-3 hover:text-green text-center"><a
                                            href="{{ route('belanja.edit', $product->id) }}"
                                            class="hover:text-white">Edit</a></td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-3 text-center">No products found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <script>
    function submitForm() {
        const stok = document.querySelector('[name="stok"]').value;
        const pemasok = document.querySelector('[name="pemasok"]').value;
        window.location.href = "{{ route('belanja') }}?stok=" + stok + "&pemasok=" + pemasok;
    }
</script>
</x-app-layout>