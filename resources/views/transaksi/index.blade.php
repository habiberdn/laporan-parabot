<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaksi') }}
        </h2>
    </x-slot>
    <div class="flex gap-4">
        <div class="w-[90%] flex flex-col">

            <form method="POST" class="p-6 flex flex-col gap-6" action={{ url('/save-transaksi') }}>
                @csrf
                {{-- Button --}}
                <div class="flex gap-4">
                    <button type="submit"
                        class="block text-white bg-[#00008B] hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl px-3 py-2.5 text-center dark:bg-[#00008B] dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan
                        Transaksi
                    </button>

                </div>
                <div id="hidden-inputs-container"></div>
                <div class="flex flex-col gap-4">
                    <div class="flex gap-4 items-center">
                        <label for="user">Nama Customer</label>
                        <input type="text" id="user" name="user" placeholder="Input Nama Customer"
                            class="rounded-xl border border-none" required>
                    </div>
                    <div class="flex gap-[3.3rem] items-center">
                        <label for="toko">Nama Toko</label>
                        <input type="text" id="toko" name="toko" placeholder="Input Nama Toko"
                            class="rounded-xl border border-none">
                    </div>
                </div>

            </form>

            <!-- Main modal -->
            <div x-data="{ show: false }" x-on:open-modal.window="$event.detail == 'default-modal' ? show = true : null"
                x-on:close-modal.window="show = false" x-on:keydown.escape.window="show = false" x-show="show"
                x-transition x-trap.noscroll.inert="show" class="fixed inset-0 z-50 overflow-y-auto"
                style="display: none;" tabindex="-1" aria-hidden="true">

                <!-- Overlay -->
                <div x-on:click="show = false" class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity">
                </div>

                <div class="flex items-center justify-center min-h-screen p-4">
                    <div x-on:click.stop class="relative p-4 w-full max-w-2xl max-h-full">

                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 form-article">
                            <!-- Modal header -->
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    {{ __('Tambah Item') }}
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
                                <div class="mb-4 flex flex-col">
                                    <label for="nama" class="block text-white font-bold mb-2">Nama
                                        Barang</label>
                                    <select name="nama" id="nama"
                                        class=" js-example-basic-single w-full py-3 pl-5 border">
                                        {{-- <input type="text" name="search" id="search"
                                            class="rounded-xl border border-none" placeholder="Cari barang"> --}}
                                        <option value="">Pilih nama barang</option>
                                        @forelse($my_products as $my_product)
                                            <option value="{{ $my_product->nama }}"
                                                data-harga-grosir="{{ $my_product->harga_grosir }}"
                                                data-image="{{ asset('storage/' . $my_product->image) }}">
                                                {{ $my_product->nama }}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="jumlah" class="block text-white font-bold mb-2">Jumlah
                                        Barang</label>
                                    <input type="number" name="jumlah" id="jumlah"
                                        class="w-full px-3 py-2 border rounded-lg @error('jumlah') border-red-500 @enderror"
                                        value="{{ old('jumlah') }}" required>
                                    @error('jumlah')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="harga_grosir" class="block text-white font-bold mb-2">Harga
                                        Grosir</label>
                                    <input type="number" name="harga_grosir" id="harga_grosir" readonly
                                        class="hover:cursor-not-allowed w-full px-3 py-2 border rounded-lg"
                                        value="{{ old('harga_grosir') }}" required>
                                    @error('harga_grosir')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="total" class="block text-white font-bold mb-2">Total</label>
                                    <input type="number" name="total" id="total" disabled
                                        class="w-full hover:cursor-not-allowed px-3 py-2 border rounded-lg @error('total') border-red-500 @enderror"
                                        value="" readonly>
                                    @error('total')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="gambar" class="block text-white font-bold mb-2">Gambar</label>
                                    <img name="image" id="gambar" alt="" >
                                    
                                    @error('total')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- Modal footer -->
                            <div
                                class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                <button x-on:click="show = false" type="button" onclick="addItemToTable()"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    {{ __('Tambah') }}
                                </button>
                                <button x-on:click="show = false" type="button"
                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                    {{ __('Batal') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg ml-[1rem]">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                No
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Barang
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Harga Jual Grosir
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Jumlah Barang
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Total
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Gambar
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex gap-4 p-6">
            <button x-data="" x-on:click="$dispatch('open-modal', 'default-modal')"
                class="block h-[3rem] w-[10rem] text-white bg-[#00008B] hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl px-3 py-2.5 text-center dark:bg-[#00008B] dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                type="button">
                Tambah Item
            </button>

            <form id="pdf-form" method="POST" action="{{ route('cetak.transaksi') }}">
                @csrf
                <input type="hidden" name="user" id="pdf-user">
                <input type="hidden" name="toko" id="pdf-toko">
                <div id="pdf-items-container"></div>
                <button type="button" id="cetak-transaksi-btn"
                    class="text-white h-[3rem] w-[10rem] bg-[#00008B] hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-center dark:bg-[#00008B] dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cetak
                    Transaksi</button>
            </form>
            <img src="" alt="">
            <a href="/riwayat"
                class="flex items-center justify-center h-12 w-40 text-white bg-[#00008B] hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg px-3 py-2.5 dark:bg-[#00008B] dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-200">
                Riwayat Transaksi
            </a>
        </div>
    </div>
</x-app-layout>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    window.addEventListener('open-modal', (event) => {
        console.log('Modal event triggered:', event.detail);
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Load cart items from localStorage
        const cart = JSON.parse(localStorage.getItem('shopping_cart')) || [];

        // Function to load cart items into the transaction table
        function loadCartItems() {
            const tbody = document.querySelector('tbody');
            const hiddenInputsContainer = document.getElementById('hidden-inputs-container');

            // Clear existing items
            tbody.innerHTML = '';
            hiddenInputsContainer.innerHTML = '';

            // Reset counters
            itemCounter = 1;
            itemIndex = 0;

            // Add each cart item to the table
            cart.forEach(item => {
                const total = parseFloat(item.harga_grosir) * parseInt(item.quantity);
                const formattedHarga = parseFloat(item.harga_grosir).toLocaleString('id-ID');
                const formattedTotal = total.toLocaleString('id-ID');

                // Create hidden inputs for form submission
                hiddenInputsContainer.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="items[${itemIndex}][nama]" value="${item.nama}">
                <input type="hidden" name="items[${itemIndex}][harga_grosir]" value="${item.harga_grosir}">
                <input type="hidden" name="items[${itemIndex}][jumlah]" value="${item.quantity}">
                <input type="hidden" name="items[${itemIndex}][total]" value="${total}">
            `);

                // Create table row
                const newRow = document.createElement('tr');
                newRow.className =
                    'odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200';
                newRow.dataset.itemIndex = itemIndex;

                newRow.innerHTML = `
                <td class="px-6 py-4">${itemCounter++}</td>
                <td class="px-6 py-4">${item.nama}</td>
                <td class="px-6 py-4">Rp ${formattedHarga}</td>
                <td class="px-6 py-4">${item.quantity}</td>
                <td class="px-6 py-4">Rp ${formattedTotal}</td>
                <td class="px-6 py-4 ">
                    <img src="{{ asset('storage/' . $my_product->image) }}" alt="" class="w-[6rem]">
                </td>

                <td class="px-6 py-4 flex gap-2">
                    <button class="delete-btn font-medium text-blue-600 dark:text-red-500 hover:underline">
                        Delete
                    </button>
                </td>
            `;

                tbody.appendChild(newRow);
                itemIndex++;

                // Add delete functionality
                newRow.querySelector('.delete-btn').addEventListener('click', function() {
                    const row = this.closest('tr');
                    const index = parseInt(row.dataset.itemIndex);

                    // Remove from cart array
                    cart.splice(index, 1);

                    // Update localStorage
                    localStorage.setItem('shopping_cart', JSON.stringify(cart));

                    // Reload cart items in the table
                    loadCartItems();
                });
            });
        }

        // Load cart items when page loads
        loadCartItems();

        // Handle form submission for saving transaction
        document.querySelector('form[action*="/save-transaksi"]').addEventListener('submit', function(e) {
            // Clear the cart after successful submission
            // This should be done on successful submission, possibly in a callback
            localStorage.removeItem('shopping_cart');
        });

        // Add new function to handle "Tambah Item" button - integrate with existing code
        const existingAddItemToTable = window.addItemToTable;

        window.addItemToTable = function() {
            existingAddItemToTable();

            // Update cart in localStorage based on the current table
            updateCartFromTable();
        };

        // Function to update cart from the current table
        function updateCartFromTable() {
            const rows = document.querySelectorAll('tbody tr');
            const updatedCart = [];

            rows.forEach((row, index) => {
                const cells = row.querySelectorAll('td');
                const productName = cells[1].textContent;
                const hargaGrosir = parseFloat(cells[2].textContent.replace('Rp ', '').replace(/\./g,
                    '').replace(',', '.'));
                const quantity = parseInt(cells[3].textContent);

                updatedCart.push({
                    id: index.toString(), // Use index as ID since we don't have the original ID
                    nama: productName,
                    harga_grosir: hargaGrosir,
                    quantity: quantity
                });
            });

            localStorage.setItem('shopping_cart', JSON.stringify(updatedCart));
        }
    });

    // Add this after the existing code
    $(document).ready(function() {
        var formChanged = false;

        // Track changes in form inputs - fix the selector to match your form class
        $('.form-article input, .form-article select, .form-article textarea').on('input change', function() {
            formChanged = true;
        });

        // Reset the flag when form is submitted
        $('.form-article').submit(function() {
            formChanged = false;
        });

        // Track changes when items are added to the table
        $(document).on('click', 'button[onclick="addItemToTable()"]', function() {
            formChanged = true;
        });

        // Track changes when items are deleted
        $(document).on('click', '.delete-btn', function() {
            formChanged = true;
        });

        // Show warning when trying to leave with unsaved changes
        window.addEventListener('beforeunload', function(e) {
            if (formChanged) {
                // Standard message for modern browsers
                const message = 'Perubahan yang Anda buat mungkin tidak tersimpan.';
                e.preventDefault(); // Cancel the event as per the standard
                e.returnValue = message; // Chrome requires returnValue to be set
                return message; // This is needed for older browsers
            }
        });
    });

    document.getElementById('nama').addEventListener('change', function() {
        // Get selected product's harga_grosir
        const selectedOption = this.options[this.selectedIndex];
        const hargaGrosir = selectedOption.getAttribute('data-harga-grosir');
        const imageUrl = selectedOption.getAttribute('data-image');

        console.log('Selected option:', selectedOption);
        console.log('Harga grosir value:', hargaGrosir);
        console.log('Image URL:', imageUrl);
        const imageElement = document.getElementById('gambar');
        imageElement.src = imageUrl; // Set the image source to the selected product's image
        imageElement.alt = selectedOption.text;

        // Update harga_grosir input
        document.getElementById('harga_grosir').value = hargaGrosir;

        // Recalculate total if jumlah has a value
        calculateTotal();
    });

    $(document).ready(function() {
        $('.js-example-basic-single').select2().on('change', function() {
            // Get selected option
            const selectedOption = $(this).find('option:selected');
            const hargaGrosir = selectedOption.data('harga-grosir');

            console.log('Selected product:', selectedOption.text());
            console.log('Harga grosir:', hargaGrosir);
            console.log("selected data", selectedOption.data());

            // Update harga_grosir input using jQuery (which might be more reliable)
            $('#harga_grosir').val(hargaGrosir);

            // Recalculate total
            calculateTotal();
        });
    });

    document.getElementById('jumlah').addEventListener('input', calculateTotal);

    function calculateTotal() {
        const jumlah = parseFloat(document.getElementById('jumlah').value) || 0;
        const hargaGrosir = parseFloat(document.getElementById('harga_grosir').value) || 0;
        const total = jumlah * hargaGrosir;

        document.getElementById('total').value = total;
    }

    let itemCounter = 1;
    let itemIndex = 0;

    function addItemToTable() {
        const selectedProduct = document.getElementById('nama');
        const selectedOption = selectedProduct.options[selectedProduct.selectedIndex];

        // Get values
        const productName = selectedOption.value;
        const hargaGrosir = parseFloat(selectedOption.getAttribute('data-harga-grosir')) || 0;
        const quantity = parseFloat(document.getElementById('jumlah').value) || 0;
        const total = hargaGrosir * quantity;

        // Validation
        if (!productName || quantity <= 0) {
            alert('Please select a product and enter quantity');
            return;
        }

        // Create table row
        const tbody = document.querySelector('tbody');
        const newRow = document.createElement('tr');
        newRow.className =
            'odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200';

        // Format numbers
        const formattedHarga = hargaGrosir.toLocaleString('id-ID');
        const formattedTotal = total.toLocaleString('id-ID');
        const container = document.getElementById('hidden-inputs-container');
        const itemPrefix = `items[${itemIndex}]`;

        container.insertAdjacentHTML('beforeend', `
        <input type="hidden" name="items[${itemIndex}][nama]" value="${productName}">
    <input type="hidden" name="items[${itemIndex}][harga_grosir]" value="${hargaGrosir}">
    <input type="hidden" name="items[${itemIndex}][jumlah]" value="${quantity}">
    <input type="hidden" name="items[${itemIndex}][total]" value="${total}">`);

        itemIndex++;
        newRow.innerHTML = `
        <td class="px-6 py-4">${itemCounter++}</td>
        <td class="px-6 py-4">${productName}</td>
        <td class="px-6 py-4">Rp ${formattedHarga}</td>
        <td class="px-6 py-4">${quantity}</td>
        <td class="px-6 py-4">Rp ${formattedTotal}</td>
        <td class="px-6 py-4 flex gap-2">
            <button class="delete-btn font-medium text-blue-600 dark:text-red-500 hover:underline">
                Delete
            </button>
         
        </td>`;

        tbody.appendChild(newRow);

        // Add delete functionality
        newRow.querySelector('.delete-btn').addEventListener('click', function() {
            const row = this.closest('tr');
            const index = row.dataset.itemIndex;

            // Hapus input hidden
            document.querySelectorAll(`input[name^="items[${index}]"]`).forEach(input => input.remove());

            row.remove();
            updateRowNumbers();
        });
        // Clear form
        selectedProduct.selectedIndex = 0;
        document.getElementById('jumlah').value = '';
        document.getElementById('harga_grosir').value = '';
        document.getElementById('total').value = '';

        // Close modal
        document.querySelector('[x-on\\:click="show = false"]').click();
    }

    function updateRowNumbers() {
        const rows = document.querySelectorAll('tbody tr');
        itemCounter = 1;
        rows.forEach(row => {
            row.querySelector('td:first-child').textContent = itemCounter++;
        });
    }

    document.getElementById('cetak-transaksi-btn').addEventListener('click', function() {
        // Check if there are items to print
        const itemInputs = document.querySelectorAll('#hidden-inputs-container input');
        if (itemInputs.length === 0) {
            alert('Tambahkan item terlebih dahulu sebelum mencetak!');
            return;
        }

        // Copy user and toko values
        document.getElementById('pdf-user').value = document.getElementById('user').value;
        document.getElementById('pdf-toko').value = document.getElementById('toko').value;

        // Copy all hidden inputs from items
        const pdfItemsContainer = document.getElementById('pdf-items-container');
        pdfItemsContainer.innerHTML = '';

        itemInputs.forEach(input => {
            pdfItemsContainer.appendChild(input.cloneNode(true));
        });

        // Submit the form
        document.getElementById('pdf-form').submit();
    });
</script>
