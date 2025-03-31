<?php

namespace App\Http\Controllers;

use App\Models\keranjang;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'harga' => 'required|numeric',
            'harga_grosir' => 'required|numeric',
            'hpp' => 'required|numeric',
            'stok' => 'required|string',
            'supplier' => 'required|string',
            'deskripsi' => 'required|string',
            'image' => 'required|string',
            'barang_id' => 'required|exists:barangs,id',
            'quantity' => 'required|integer|min:1'
        ]);

        // Check if item already exists in cart
        $existingItem = Keranjang::where('user_id', Auth::id())
            ->where('barang_id', $request->barang_id)
            ->first();

        if ($existingItem) {
            // Update quantity if item already exists
            $existingItem->quantity += $request->quantity;
            $existingItem->save();
        } else {
            // Create new cart item
            Keranjang::create([
                'user_id' => Auth::id(),
                'barang_id' => $request->barang_id,
                'nama' => $request->nama,
                'harga' => $request->harga,
                'harga_grosir' => $request->harga_grosir,
                'image' => $request->image,
                'quantity' => $request->quantity
            ]);
        }

        return redirect()->back()->with('success', 'Item added to cart successfully');
    }

    /**
     * Display the user's shopping cart
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cartItems = Keranjang::where('user_id', Auth::id())->get();
        $total = $cartItems->sum(function($item) {
            return $item->harga * $item->quantity;
        });
        
        return view('barang.cart', compact('cartItems', 'total'));
    }

    /**
     * Update cart item quantity
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Keranjang::findOrFail($id);
        
        // Check if user owns this cart item
        if ($cartItem->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You do not have permission to update this item');
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->back()->with('success', 'Cart updated successfully');
    }

    /**
     * Remove item from cart
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cartItem = Keranjang::findOrFail($id);
        
        // Check if user owns this cart item
        if ($cartItem->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You do not have permission to remove this item');
        }

        $cartItem->delete();

        return redirect()->back()->with('success', 'Item removed from cart');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(keranjang $keranjang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(keranjang $keranjang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
 
}
