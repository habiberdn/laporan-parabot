<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use App\Models\Barang;
use App\Models\belanja;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product removed from cart!');
    }

    public function viewCart()
    {
        $cart = session()->get('cart');
        return view('barang.cart', compact('cart'));
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
                'nama' => 'string|max:255',
                'harga' => 'integer|min:0',
                'harga_grosir' => 'integer|min:0',
                'hpp' => 'integer|min:0',
                'deskripsi' => 'string',
                'supplier' => 'string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
                'stok' => 'nullable|string|in:ada,kosong',
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
            Barang::create($validated);
            Belanja::create([
                'nama_barang' => $validated['nama'],
                'jumlah_pesanan' => 0,
                'satuan' => $validated['harga'],
                'pemasok' => $validated['supplier'],
                'gambar' => $validated['image'],
                'stok' => 'ada',
            ]);
            // Create the record

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
        $barang = Barang::where('id', $product->id)->first();
        $suppliers = Supplier::all();

        return view('barang.edit', [
            'barang' => $barang,
            'suppliers' => $suppliers,
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
     
    public function update(Request $request, Barang $barang)
{
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'harga' => 'required|integer|min:0',
        'harga_grosir' => 'required|integer|min:0',
        'hpp' => 'required|integer|min:0',
        'deskripsi' => 'required|string',
        'supplier' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:7072',
        'stok' => 'required|string|in:ada,kosong',
    ]);
    try {
        // Image handling
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($barang->image && Storage::disk('public')->exists($barang->image)) {
                Storage::disk('public')->delete($barang->image);
            }
            $file = $request->file('image');
            $manager = ImageManager::withDriver(new Driver());
            $image = $manager->read($file->getRealPath());
            $image->toWebp(75);
            $image->pad(1200, 800, 'ffffff', 'center');
            $filename = Str::slug($validated['nama']) . '_' . uniqid() . '.webp';
            $path = 'image/' . $filename;
            // Save the image
            Storage::disk('public')->put($path, $image->encode());
            $validated['image'] = $path;
        } else {
            // Remove the image from validated data to keep the existing image
            unset($validated['image']);
        }
        // Update Barang
        $barang->update($validated);
       
        // Find or create Belanja entry related to this Barang
        $belanja = Belanja::where('nama_barang', $barang->nama)->first();
        
        if ($belanja) {
            // Update existing Belanja record
            $belanja->update([
                'nama_barang' => $validated['nama'],
                'satuan' => $validated['harga'],
                'pemasok' => $validated['supplier'],
                'gambar' => $barang->image,
                'stok' => $validated['stok'],
            ]);
        } else {
            // Create new Belanja record if not exists
            Belanja::create([
                'nama_barang' => $validated['nama'],
                'jumlah_pesanan' => 0,
                'satuan' => $validated['harga'],
                'pemasok' => $validated['supplier'],
                'gambar' => $barang->image,
                'stok' => $validated['stok'],
            ]);
        }
        
        return redirect()->route('dashboard')->with('success', 'Produk berhasil diperbarui!');
    } catch (\Exception $e) {
        Log::error('Barang update error: ' . $e->getMessage());
        return back()->withErrors(['system_error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
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