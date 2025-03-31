<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Transaksi') }}
        </h2>
    </x-slot>
    <div class="p-4 md:p-5 space-y-4 overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Transaksi ID</th>
                    <th scope="col" class="px-6 py-3">Nama Barang</th>
                    <th scope="col" class="px-6 py-3">Harga Grosir</th>
                    <th scope="col" class="px-6 py-3">Jumlah</th>
                    <th scope="col" class="px-6 py-3">Total</th>
                    <th scope="col" class="px-6 py-3">User</th>
                    <th scope="col" class="px-6 py-3">Toko</th>
                    <th scope="col" class="px-6 py-3">Aksi</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    @foreach ($transaction->items as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ $transaction->id }}</td>
                            <td class="px-6 py-4">{{ $item->nama_barang }}</td>
                            <td class="px-6 py-4">Rp
                                {{ number_format($item->harga_grosir, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">{{ $item->jumlah }}</td>
                            <td class="px-6 py-4">Rp
                                {{ number_format($item->total, 0, ',', '.') }}</td>
                            @if ($loop->first)
                                <td class="px-6 py-4" rowspan="{{ count($transaction->items) }}">
                                    {{ $transaction->user }}</td>
                                <td class="px-6 py-4" rowspan="{{ count($transaction->items) }}">
                                    {{ $transaction->toko }}</td>
                                    <td class="px-6 py-4" rowspan="{{ count($transaction->items) }}">
                                        <button
                                            class="h-[3rem] w-[10rem] text-white bg-[#00008B] hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl px-3 py-2.5 transition-colors duration-200 dark:bg-[#00008B] dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                            type="button" onclick="window.location.href='{{ url('/details?transaction_id=' . $transaction->id) }}'">
                                            Details
                                        </button>
                                    </td>
                            @endif

                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        <button onclick="window.history.back()"
            class="h-[3rem] w-[10rem] text-white bg-[#00008B] hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl px-3 py-2.5 transition-colors duration-200 dark:bg-[#00008B] dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            type="button" aria-label="Navigate back">
            Kembali
        </button>
    </div>
</x-app-layout>