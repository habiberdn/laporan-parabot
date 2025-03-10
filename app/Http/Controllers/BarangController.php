<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use App\Models\Barang;
use App\Models\supplier; // Add this at the top

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $my_products = Barang::all();
        return view('barang.dashboard', compact('my_products'));
    }

    public function addToCart(Request $request)
    {
        $product = Barang::findOrFail($request->id);

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "nama" => $product->nama,
                "harga" => $request->harga,
                "supplier" => $product->supplier,
                "image" => $product->images
            ];
        }

        $request->session()->put('cart', $cart);

        $cart_products = collect(request()->session()->get('cart'));

        $renderHTML = view('barang.cart', compact('cart_products'))->render();
        $total_products_count = count(request()->session()->get('cart'));
        return response()->json(['renderHTML' => $renderHTML, 'total_products_count' => $total_products_count], 200);
    }


    public function search(Request $request)
    {
        $keyword = $request->input('search');
        $barang = Barang::query()
            ->where('nama', 'LIKE', '%' . $keyword . '%')->get();

        return view('barang.search', [
            'barangs' => $barang
        ]);
    }

    public function getSupplier()
    {
        $suppliers = Supplier::all();
        return view('barang.add', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate first
            $validated = $request->validate([
                'nama' => 'required|string|max:255|unique:barangs,nama',
                'harga' => 'required|integer|min:0',
                'harga_grosir' => 'required|integer|min:0',
                'hpp' => 'required|integer|min:0',
                'deskripsi' => 'required|string',
                'supplier' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,webp,JPG'
            ]);
            if (!$request->hasFile('image')) {
                throw ValidationException::withMessages([
                    'image' => ['The image file is required.'],
                ]);
            }
            if (Barang::where('nama', $request->nama)->exists()) {
                throw ValidationException::withMessages([
                    'nama' => ['Nama barang sudah ada.'],
                ]);
            }

            $file = $request->file('image');

            // Process the image
            $manager = ImageManager::withDriver(new Driver());
            $image = $manager->read($file->getRealPath());
            $image->toWebp(75);
            // $image->pad(800, 500, 'ffffff', 'center');
            $image->scale(3200);

            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
            $path = 'image/' . $filename;

            // Save the image
            Storage::disk('public')->put($path, $image->encode());

            // Update validated data with the image path
            $validated['image'] = $path;

            // Create the record
            Barang::create($validated);

            return redirect()->route('dashboard')->with('success', 'Barang berhasil ditambahkan');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            report($e); // Log the error
            throw ValidationException::withMessages([
                'system_error' => ['Terjadi kesalahan sistem: ' . $e->getMessage()],
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        //
    }

    public function details(Barang $product)
    {
        $barang =  Barang::where('id', $product->id)->first();
        return view('barang.edit', [
            'barang' => $barang,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $Barang)
    {
        $validated = $request->validate([
            'nama' => 'string|max:255',
            'harga' => 'integer|min:0',
            'harga_grosir' => 'integer|min:0',
            'hpp' => 'integer|min:0',
            'deskripsi' => 'string',
            'supplier' => 'string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,webp|max:3072'
        ]);

        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');

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
                $validated['image'] = $path;
            }

            $Barang->update($validated);
            return redirect()->route('dashboard')->with('success', 'Product created successfuly!');
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
    public function destroy(Barang $barang)
    {
        //
    }
}
