<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Supplier') }}
        </h2>
    </x-slot>
    <div class="p-6 flex w-full">
        <div class="bg-white w-full rounded-lg flex flex-col  shadow-lg p-6">
            <form action="{{ url('/save-supplier') }}" method="POST" class="flex flex-col gap-4">
                @csrf
                <div class="flex gap-2 w-full flex items-center  ">
                    <label for="supplier">Nama Supplier</label>
                    <input type="text" name="nama" id="supplier"
                            class="w-[80%]  px-3  border rounded-lg @error('supplier') border-red-500 @enderror"
                            value="{{ old('supplier') }}" required>
                </div>
                <div class="flex justify-end gap-2 w-full">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                        Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Check if there's a success message in the session
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                timerProgressBar: true
            });
        @endif
        
        // Check if there are validation errors
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ $errors->first() }}",
            });
        @endif
    </script>
</x-app-layout>