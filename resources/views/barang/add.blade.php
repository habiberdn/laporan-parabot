<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Barang') }}
        </h2>
    </x-slot>

    <div class=" mx-auto p-6 flex  w-full">
        <div class="bg-white rounded-lg flex flex-col w-full shadow-lg p-6 ">
            <form action="{{ url('/save-barang') }}" method="POST" enctype="multipart/form-data" class="article-form">
                @csrf
                <div id="image-preview"
                    class="w-[20%] p-4  mb-2 bg-gray-100 border-dashed border-2 border-gray-400 rounded-lg items-start text-center cursor-pointer">
                    <input id="upload" type="file" name="image" accept="image/*" class="hidden" required />
                    <div id="preview-content" class="w-full">
                        <label for="upload" class="cursor-pointer w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-8 h-8 text-gray-700 mx-auto mb-2 @error('image') border-red-500 @enderror">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                            </svg>
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-700">Upload Gambar</h5>
                            <p class="font-normal text-sm text-gray-400 md:px-6">Pilih Ukuran Gambar Lebih Kecil
                                dari
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
                    <label for="nama" class="block text-gray-700 font-bold mb-2">Nama Barang</label>
                    <input type="text" name="nama" id="nama"
                        class="w-[80%]  px-3  border rounded-lg @error('nama') border-red-500 @enderror"
                        placeholder="Input nama barang" required>
                    @error('nama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col ">
                    <div class="mb-2">
                        <label for="harga" class="block text-gray-700 font-bold mb-2">Harga Satuan</label>
                        <input type="number" name="harga" id="harga"
                            class="w-[80%] px-3  border rounded-lg @error('harga') border-red-500 @enderror"
                            value="{{ old('harga') }}" placeholder="Input harga" required>
                        @error('harga')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="harga_grosir" class="block text-gray-700 font-bold mb-2">Harga Grosir</label>
                        <input type="number" name="harga_grosir" id="harga_grosir"
                            class="w-[80%] px-3  border rounded-lg @error('harga_grosir') border-red-500 @enderror"
                            placeholder="Input harga grosir" required>
                        @error('harga_grosir')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="hpp" class="block text-gray-700 font-bold mb-2">Harga Modal</label>
                        <input type="number" name="hpp" id="hpp"
                            class="w-[80%] px-3  border rounded-lg @error('hpp') border-red-500 @enderror"
                            placeholder="Input harga modal" required>
                        @error('hpp')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-2">
                    <label for="supplier" class="block text-gray-700 font-bold mb-2">Supplier</label>
                    <div class="mb-4 flex flex-col">
                        <select name="supplier" id="supplier"
                            class="w-[80%] px-3  border rounded-lg @error('supplier') border-red-500 @enderror">
                            <option value="">Pilih Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->nama }}">
                                    {{ $supplier->nama }} <!-- Assuming the Supplier model has a "nama" field -->
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-2">
                    <label for="deskripsi" class="block text-gray-700 font-bold mb-2">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"
                        class="w-[80%] px-3  border rounded-lg @error('deskripsi') border-red-500 @enderror" required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
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
        const uploadInput = document.getElementById('upload');
        const filenameLabel = document.getElementById('filename');
        const imagePreview = document.getElementById('image-preview');
        const previewContent = document.getElementById('preview-content');
        const imageContainer = document.getElementById('image-container');
        // let isSubmitting = false;
        // window.isFormDirty = false; // Flag to track if the form has unsaved changes

        // document.addEventListener('DOMContentLoaded', function() {
        //     const formInputs = document.querySelectorAll('input, textarea', 'option', 'select');

        //     // Add change event listener to each input
        //     formInputs.forEach(input => {
        //         // Store the original value when the page loads
        //         const originalValue = input.value;
        //         console.log(input)
        //         input.addEventListener('change', function() {

        //             if (this.value !== originalValue) {
        //                 console.log("this.value", this.value);
        //                 console.log("originalValue", originalValue);
        //                 window.isFormDirty = true;

        //             }
        //         });
        //     });
        // });

     
        // Find this form submission event handler in your code
        document.querySelector('form').addEventListener('submit', function(e) {
            isSubmitting = true;
            window.isFormDirty = false;
            console.log('submit triggered')
            // Validasi gambar
            if (!uploadInput.files || !uploadInput.files[0]) {
                e.preventDefault();
                alert('Harap pilih gambar');
                isSubmitting = false; 
                window.isFormDirty = true; 
                return false;
            }
        });

        uploadInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                filenameLabel.textContent = file.name;
                const reader = new FileReader();

                reader.onload = (e) => {
                    previewContent.classList.add('hidden');
                    imageContainer.classList.remove('hidden');
                    imageContainer.innerHTML = `
                        <img src="${e.target.result}" class="max-h-48 rounded-lg mx-auto" alt="Existing image" />
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
        }

        // Prevent event bubbling when clicking the file input
        uploadInput.addEventListener('click', (event) => {
            event.stopPropagation();
        });
    </script>
</x-app-layout>