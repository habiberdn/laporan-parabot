<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Keranjang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if ($cartItems->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-3 px-6 text-left">Product</th>
                                        <th class="py-3 px-6 text-left">Harga</th>
                                        <th class="py-3 px-6 text-left">Jumlah</th>
                                        <th class="py-3 px-6 text-left">Subtotal</th>
                                        <th class="py-3 px-6 text-left">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($cartItems as $item)
                                        <tr>
                                            <td class="py-4 px-6">
                                                <div class="flex items-center">
                                                    <img src="{{ asset('storage/' . $item->image) }}"
                                                        alt="{{ $item->nama }}" class="h-12 w-12 object-cover mr-4">
                                                    <span>{{ $item->nama }}</span>
                                                </div>
                                            </td>
                                            <td class="py-4 px-6">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                            <td class="py-4 px-6">
                                                <form action="{{ route('keranjang.update', $item->id) }}" method="POST"
                                                    class="flex items-center">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                        min="1" class="w-16 border rounded p-2">
                                                    <button type="submit"
                                                        class="ml-2 text-blue-500 hover:text-blue-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="py-4 px-6">Rp
                                                {{ number_format($item->harga * $item->quantity, 0, ',', '.') }}</td>
                                            <td class="py-4 px-6">
                                                <form action="{{ route('keranjang.destroy', $item->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="border-t-2 border-gray-200">
                                        <td colspan="3" class="py-4 px-6 text-right font-bold">Total:</td>
                                        <td class="py-4 px-6 font-bold">Rp {{ number_format($total, 0, ',', '.') }}
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <form action="{{ url('/save-transaksi') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Proceed to Checkout
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="mt-2 text-xl font-medium text-gray-900">Your cart is empty</h3>
                            <p class="mt-1 text-gray-500">Looks like you haven't added any items to your cart yet.</p>
                            <div class="mt-6">
                                <a href="{{ route('barang.index') }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
