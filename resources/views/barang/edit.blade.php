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
                    <input id="upload" type="file" name="image" accept="image/*" class="hidden" required
                        value="{{ asset('storage/' . $barang->image) }}" />
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
                    <label for="supplier" class="block text-gray-700 font-bold mb-2 w-[7rem]">Supplier</label>
                    <input type="text" name="supplier" id="supplier"
                        class="w-full px-3 py-2 border rounded-lg @error('supplier') border-red-500 @enderror"
                        value="{{ $barang->supplier }}" required>
                    @error('supplier')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
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
            <form action="">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    + Keranjang
                </button>
            </form>
        </div>
    </div>

    <script>
        const uploadInput = document.getElementById('upload');
        const filenameLabel = document.getElementById('filename');
        const imagePreview = document.getElementById('image-preview');
        const previewContent = document.getElementById('preview-content');
        const imageContainer = document.getElementById('image-container');

        function toggleHPPVisibility() {
            const hppInput = document.getElementById('hpp');
            const toggleButton = document.getElementById('toggleHPPButton');

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

        uploadInput.addEventListener('change', (event) => {
            const file = event.target.files[0];

            if (file) {
                filenameLabel.textContent = file.name;
                const reader = new FileReader();

                reader.onload = (e) => {
                    previewContent.classList.add('hidden');
                    imageContainer.classList.remove('hidden');
                    imageContainer.innerHTML = `
                <img src="${e.target.result}" class="max-h-48 rounded-lg mx-auto" alt="Image preview" />
                <button type="button" class="mt-2 text-gray-500 hover:text-gray-700" id="remove-image">
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
            uploadInput.value = '';
            filenameLabel.textContent = '';
            previewContent.classList.remove('hidden');
            imageContainer.classList.add('hidden');
            imageContainer.innerHTML = '';
            imagePreview.classList.add('border-dashed', 'border-2', 'border-gray-400');

            // If there was an existing image, make the input required again
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
