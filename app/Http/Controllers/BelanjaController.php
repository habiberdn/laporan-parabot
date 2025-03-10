<?php

namespace App\Http\Controllers;

use App\Models\belanja;
use Illuminate\Validation\ValidationException;
use Intervention\Image\ImageManager;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use App\Models\supplier;

class BelanjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Belanja::query();

        // Search filter
        if ($request->has('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        // Stock filter
        if ($request->has('stok') && in_array($request->stok, ['ada', 'kosong'])) {
            $query->where('stok', $request->stok);
        }

        // Pemasok filter
        if ($request->has('pemasok') && $request->pemasok != '') {
            $query->where('pemasok', $request->pemasok);
        }

        // Get unique pemasok list for dropdown
        $pemasokList = Belanja::distinct()->pluck('pemasok');

        $belanja = $query->paginate(10);

        return view('belanja.index', compact('belanja', 'pemasokList'));
        // $belanja = Belanja::all();
        // return view('belanja.index', compact('belanja'));
    }

    public function addBelanja()
    {
        $suppliers = Supplier::all(); // Ambil semua data supplier
        return view('belanja.add', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function reset(Request $request, belanja $belanja)
    {
        try {
            // Update all records using Eloquent
            Belanja::query()->update(['stok' => 'kosong']);

            return redirect()->back()
                ->with('success', 'Semua stok berhasil direset ke status kosong');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mereset stok: ' . $e->getMessage());
        }
    }

    public function filterByStok(Request $request)
    {
        $validated = $request->validate([
            'stok' => 'required|in:ada,kosong'
        ]);
        $stokStatus = $validated['stok'];

        $belanja = Belanja::where('stok', $stokStatus)
            ->orderBy('created_at', 'desc')
            ->get(); // Execute the query

        return view('belanja.filter', [
            'belanja' => $belanja,
            'currentFilter' => $stokStatus
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_barang' => 'required|string|max:255',
                'jumlah_pesanan' => 'required|integer|min:0',
                'satuan' => 'required|integer|min:0',
                'stok' => 'required|string|in:ada,kosong',
                'pemasok' => 'required|string',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,webp,JPG|max:3072'
            ]);
            if (!$request->hasFile('gambar')) {
                throw ValidationException::withMessages([
                    'gambar' => ['Gambar harus diinput.'],
                ]);
            }


            $file = $request->file('gambar');

            // Process the image
            $manager = ImageManager::withDriver(new Driver());
            $image = $manager->read($file->getRealPath());
            $image->toWebp(75);
            $image->scale(3200);

            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
            $path = 'image/' . $filename;

            // Save the image
            Storage::disk('public')->put($path, $image->encode());

            // Update validated data with the image path
            $validated['gambar'] = $path;

            // Create the record
            Belanja::create($validated);

            return redirect()->route('belanja')->with('success', 'Belanja berhasil ditambahkan');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            report($e); // Log the error
            throw ValidationException::withMessages([
                'system_error' => ['Terjadi kesalahan sistem: ' . $e->getMessage()],
            ]);
        }
    }

    public function details(belanja $belanja)
    {
        $barang =  Belanja::where('id', $belanja->id)->first();
        return view('belanja.edit', [
            'belanja' => $barang,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(belanja $belanja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(belanja $belanja) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, belanja $belanja)
    {
        $validated = $request->validate([
            'nama_barang' => 'string|max:255',
            'jumlah_pesanan' => 'integer|min:0',
            'satuan' => 'integer|min:0',
            'stok' => 'string|in:ada,kosong',
            'pemasok' => 'string',
            'gambar' => 'image|mimes:jpeg,png,jpg,webp,JPG|max:3072'
        ]);

        try {
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');

                // Process the image
                $manager = ImageManager::withDriver(new Driver());
                $image = $manager->read($file->getRealPath());
                $image->toWebp(75);
                $image->pad(1200, 800, 'ffffff', 'center');

                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
                $path = 'image/' . $filename;

                // Save the image
                Storage::disk('public')->put($path, $image->encode());

                // Update validated data with the image path
                $validated['gambar'] = $path;
            }

            $belanja->update($validated);
            return redirect()->route('belanja')->with('success', 'Product created successfuly!');
        } catch (\Exception $e) {
            dd($e);
            $error = ValidationException::withMessages([
                'system_error' => ['System error!' . $e->getMessage()],
            ]);

            throw $error;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(belanja $belanja)
    {
        //
    }
}
