<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Barang') }}
        </h2>
    </x-slot>

    <div class="p-6 flex w-full">
        <div class="bg-white w-full rounded-lg flex flex-col  shadow-lg p-6">

            <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div id="image-preview"
                    class="w-[20%] p-4  mb-2 bg-gray-100 border-dashed border-2 border-gray-400 rounded-lg items-start text-center cursor-pointer">
                    <input id="upload" type="file" name="image" accept="image/*" class="hidden"
                        value="{{ $barang->image ? asset('storage/' . $barang->image) : '' }}" />
                    <div id="preview-content">
                        <label for="upload" class="cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-8 h-8 text-gray-700 mx-auto mb-4 @error('image') border-red-500 @enderror">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                            </svg>
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-700">Upload picture</h5>
                            <p class="font-normal text-sm text-gray-400 md:px-6">Choose photo size should be less than
                                <b class="text-gray-600">3mb</b>
                            </p>
                            <span id="filename" class="text-gray-500 bg-gray-200 z-50"></span>
                        </label>
                    </div>
                    <div id="image-container" class="hidden"></div>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4 flex items-center gap-2 mt-[2rem]">
                    <label for="nama" class="block text-gray-700 font-bold mb-2 w-[7rem] ">Nama Barang</label>

                    <input type="text" name="nama" id="nama"
                        class="w-full px-3 py-2 border rounded-lg @error('nama') border-red-500 @enderror"
                        value="{{ $barang->nama }}" required>
                    @error('nama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col">
                    <div class="mb-4 flex items-center gap-2">
                        <label for="harga" class="block text-gray-700 font-bold mb-2 w-[7rem]">Harga Satuan</label>
                        <input type="number" name="harga" id="harga"
                            class="w-full px-3 py-2 border rounded-lg @error('harga') border-red-500 @enderror"
                            value="{{ $barang->harga }}" required>
                        @error('harga')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4 flex items-center gap-2">
                        <label for="harga_grosir" class="block text-gray-700 font-bold mb-2 w-[7rem]">Harga
                            Grosir</label>
                        <input type="number" name="harga_grosir" id="harga_grosir"
                            class="w-full px-3 py-2 border rounded-lg @error('harga_grosir') border-red-500 @enderror"
                            value="{{ $barang->harga_grosir }}" required>
                        @error('harga_grosir')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4 flex items-center gap-2">
                        <label for="hpp" class="block text-gray-700 font-bold mb-2 w-[7rem]">Harga Modal</label>
                        <div class="flex items-center gap-2 w-full">
                            <input type="number" name="hpp" id="hpp"
                                class="w-full px-3 py-2 border rounded-lg @error('hpp') border-red-500 @enderror"
                                value="{{ $barang->hpp }}" required>
                            <button type="button" onclick="toggleHPPVisibility()" id="toggleHPPButton"
                                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors">
                                Hide
                            </button>
                        </div>
                        @error('hpp')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4 flex items-center gap-2">
                    <label for="stok" class="block text-gray-700 font-bold mb-2 w-[7rem]">Stok</label>
                    <select name="stok" id="stok"
                        class="w-full px-3 border rounded-lg @error('stok') border-red-500 @enderror">
                        <option value="">Pilih Stok</option>
                        <option value="ada" {{ $barang->stok == 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="kosong" {{ $barang->stok == 'kosong' ? 'selected' : '' }}>Kosong</option>
                    </select>
                    @error('stok')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4 flex items-center gap-2">
                    <label for="supplier" class="block text-gray-700 font-bold mb-2 w-[7rem]">Supplier</label>
                    <select name="supplier" id="supplier"
                        class="w-full px-3 border rounded-lg @error('supplier') border-red-500 @enderror">
                        <option value="">Pilih Supplier</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->nama }}"
                                {{ $barang->supplier == $supplier->nama ? 'selected' : '' }}>
                                {{ $supplier->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4 flex items-center gap-2">
                    <label for="deskripsi" class="block text-gray-700 font-bold mb-2 w-[7rem]">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"
                        class="w-full px-3 py-2 border rounded-lg @error('deskripsi') border-red-500 @enderror" required>{{ $barang->deskripsi }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                        Update
                    </button>
            </form>
            <form action="{{ route('dashboard') }}">
                @csrf
                <input type="hidden" value="{{ $barang->id }}" name="barang_id">
                <input type="hidden" value="{{ $barang->nama }}" name="nama">
                <input type="hidden" name="harga" value="{{ $barang->harga }}">
                <input type="hidden" name="harga_grosir" value="{{ $barang->harga_grosir }}">
                <input type="hidden" name="hpp" value="{{ $barang->hpp }}">
                <input type="hidden" name="stok" value="{{ $barang->stok }}">
                <input type="hidden" name="supplier" value="{{ $barang->supplier }}">
                <input type="hidden" name="deskripsi" value="{{ $barang->deskripsi }}">
                <input type="hidden" name="image" value="{{ $barang->image }}">
                <input type="hidden" name="quantity" value="1">

                <button type="submit" id='keranjang'
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    + Keranjang
                </button>
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    <script>
        const uploadInput = document.getElementById('upload');
    const filenameLabel = document.getElementById('filename');
    const imagePreview = document.getElementById('image-preview');
    const previewContent = document.getElementById('preview-content');
    const imageContainer = document.getElementById('image-container');
    const hppInput = document.getElementById('hpp');
    const toggleButton = document.getElementById('toggleHPPButton');

    // By default, set HPP input to password type
    hppInput.type = 'password';
    toggleButton.textContent = 'Show';

    $(document).ready(function() {
        var formChanged = false;
        $('.article-form input, .article-form select,  .article-form textarea').on('input change', function() {
            formChanged = true;
        });

        $('.article-form').submit(function() {
            formChanged = false;
        });

        $(window).on('beforeunload', function() {
            if (formChanged) {
                return 'Changes you made may not be saved.';
            }
        });
    });

    function toggleHPPVisibility() {
        if (hppInput.type === 'number') {
            hppInput.type = 'password';
            toggleButton.textContent = 'Show';
        } else {
            hppInput.type = 'number';
            toggleButton.textContent = 'Hide';
        }
    }

        // Add this at the beginning to show existing image
        if ('{{ $barang->image }}') {
            const existingImage = '{{ asset('storage/' . $barang->image) }}';
            previewContent.classList.add('hidden');
            imageContainer.classList.remove('hidden');
            imageContainer.innerHTML = `
        <img src="${existingImage}" class="max-h-48 rounded-lg mx-auto" alt="Existing image" />
        <button type="button" class="mt-2 text-gray-500 hover:text-gray-700" id="remove-image">
            Change Image
        </button>
    `;
            imagePreview.classList.remove('border-dashed', 'border-2', 'border-gray-400');
            uploadInput.removeAttribute('required'); // Remove required if image exists
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Get the add to cart button
            const addToCartBtn = document.getElementById('keranjang');

            // Add click event listener
            addToCartBtn.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Get product data from the form
                const productData = {
                    id: document.querySelector('input[name="barang_id"]').value,
                    nama: document.querySelector('input[name="nama"]').value,
                    harga: document.querySelector('input[name="harga"]').value,
                    harga_grosir: document.querySelector('input[name="harga_grosir"]').value,
                    hpp: document.querySelector('input[name="hpp"]').value,
                    stok: document.querySelector('input[name="stok"]').value,
                    supplier: document.querySelector('input[name="supplier"]').value,
                    deskripsi: document.querySelector('input[name="deskripsi"]').value,
                    image: document.querySelector('input[name="image"]').value,
                    quantity: document.querySelector('input[name="quantity"]').value || 1
                };

                // Get existing cart from localStorage or create a new one
                let cart = JSON.parse(localStorage.getItem('shopping_cart')) || [];

                // Check if the product already exists in the cart
                const existingProductIndex = cart.findIndex(item => item.id === productData.id);

                if (existingProductIndex !== -1) {
                    // If product exists, increment its quantity
                    cart[existingProductIndex].quantity = parseInt(cart[existingProductIndex].quantity) + 1;
                } else {
                    // If product doesn't exist, add it to cart
                    cart.push(productData);
                }

                // Save updated cart to localStorage
                localStorage.setItem('shopping_cart', JSON.stringify(cart));

                // Show success message
                alert('Produk berhasil ditambahkan ke keranjang!');

                // Redirect to transaction page if needed
                // window.location.href = '/transaksi';
            });
        });

        uploadInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            const maxSize = 3 * 1024 * 1024; // 3MB

            if (file) {
                // Validate file type and size
                if (!allowedTypes.includes(file.type)) {
                    alert('Please upload a valid image (JPEG, PNG, WebP)');
                    resetImagePreview();
                    return;
                }

                if (file.size > maxSize) {
                    alert('File size should be less than 3MB');
                    resetImagePreview();
                    return;
                }

                filenameLabel.textContent = file.name;
                const reader = new FileReader();
                reader.onload = (e) => {
                    const base64Image = e.target.result;
                    localStorage.setItem('image', base64Image);
                    previewContent.classList.add('hidden');
                    imageContainer.classList.remove('hidden');
                    imageContainer.innerHTML = `
                <img src="${e.target.result}" 
                     class="max-h-48 rounded-lg mx-auto" 
                     alt="Image preview" />
                <button type="button" 
                        class="mt-2 text-gray-500 hover:text-gray-700" 
                        id="remove-image">
                    Change Image
                </button>
            `;

                    imagePreview.classList.remove('border-dashed', 'border-2', 'border-gray-400');

                    document.getElementById('remove-image').addEventListener('click', (e) => {
                        e.stopPropagation();
                        resetImagePreview();
                    });
                };

                reader.readAsDataURL(file);
            } else {
                resetImagePreview();
            }
        });

        function resetImagePreview() {
            uploadInput.value = ''; // Clear the file input
            filenameLabel.textContent = '';
            previewContent.classList.remove('hidden');
            imageContainer.classList.add('hidden');
            imageContainer.innerHTML = '';
            imagePreview.classList.add('border-dashed', 'border-2', 'border-gray-400');

            // If no existing image, make input required
            if ('{{ $barang->image }}' === '') {
                uploadInput.setAttribute('required', 'required');
            }
        }

        // Prevent event bubbling when clicking the file input
        uploadInput.addEventListener('click', (event) => {
            event.stopPropagation();
        });

        // Add click handler to the preview container
        imagePreview.addEventListener('click', () => {
            uploadInput.click();
        });
    </script>
</x-app-layout>