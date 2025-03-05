<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Belanja') }}
        </h2>
    </x-slot>
    <div class=" mx-auto p-6 flex  w-full">
        <div class="bg-white rounded-lg flex flex-col w-full shadow-lg p-6 ">
            <form action="{{ route('belanja.update', $belanja->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div id="image-preview"
                    class="w-[20%] p-4  mb-2 bg-gray-100 border-dashed border-2 border-gray-400 rounded-lg items-start text-center cursor-pointer">
                    <input id="upload" type="file" name="gambar" accept="image/*" class="hidden" required
                        value="{{ asset('storage/' . $belanja->image) }}" />
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


                <div class="mb-2">
                    <label for="nama_barang" class="block text-gray-700 font-bold mb-2">Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang"
                        class="w-[80%]  px-3  border rounded-lg @error('nama') border-red-500 @enderror"
                        value="{{ $belanja->nama_barang }}" required>
                    @error('nama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col ">
                    <div class="mb-2">
                        <label for="satuan" class="block text-gray-700 font-bold mb-2">Harga Satuan</label>
                        <input type="number" name="satuan" id="satuan"
                            class="w-[80%] px-3  border rounded-lg @error('satuan') border-red-500 @enderror"
                            value="{{ $belanja->satuan }}" required>
                        @error('satuan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="jumlah_pesanan" class="block text-gray-700 font-bold mb-2">Jumlah Pesanan</label>
                        <input type="number" name="jumlah_pesanan" id="jumlah_pesanan"
                            class="w-[80%] px-3  border rounded-lg @error('jumlah_pesanan') border-red-500 @enderror"
                            value="{{ $belanja->jumlah_pesanan }}" required>
                        @error('jumlah_pesanan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="stok" class="block text-gray-700 font-bold mb-2">Stok</label>
                        <select name="stok" id="stok"
                            class="w-[80%] px-3 border rounded-lg @error('stok') border-red-500 @enderror">
                            <option value="">Pilih Stok</option>
                            <option value="ada" {{ old('stok', $belanja->stok ?? '') == 'ada' ? 'selected' : '' }}>
                                Ada</option>
                            <option value="kosong"
                                {{ old('stok', $belanja->stok ?? '') == 'kosong' ? 'selected' : '' }}>Kosong</option>
                        </select>
                        @error('stok')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="mb-2">
                        <label for="pemasok" class="block text-gray-700 font-bold mb-2">Pemasok</label>
                        <input type="text" name="pemasok" id="pemasok"
                            class="w-[80%] px-3  border rounded-lg @error('pemasok') border-red-500 @enderror"
                            value="{{ $belanja->pemasok }}" required>
                        @error('pemasok')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="flex justify-end gap-2 w-[80%]">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                            Simpan
                        </button>

                    </div>
            </form>
        </div>
    </div>

    <script>
        const uploadInput = document.getElementById('upload');
        const filenameLabel = document.getElementById('filename');
        const imagePreview = document.getElementById('image-preview');
        const previewContent = document.getElementById('preview-content');
        const imageContainer = document.getElementById('image-container');

        // Add this at the beginning to show existing image
        if ('{{ $belanja->gambar }}') {
            const existingImage = '{{ asset('storage/' . $belanja->gambar) }}';
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
            if ('{{ $belanja->gambar }}' === '') {
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
