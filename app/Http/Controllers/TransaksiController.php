<?php

namespace App\Http\Controllers;

use App\Models\transaksi;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\TransaksiItem;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelPdf\Facades\Pdf;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $my_products = Barang::all();
        return view('transaksi.index', compact('my_products'));
    }

    public function riwayat(Request $request) {
        $transactions = Transaksi::with('items')->latest()->get();
        return view('transaksi.riwayat', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function cetakTransaksi(Request $request)
    {


        $user = $request->input('user');
        $toko = $request->input('toko');
        $items = $request->input('items', []);

        return Pdf::view('transaksi.pdf', [
            'user' => $user,
            'toko' => $toko,
            'items' => $items,
        ])->download('transaksi-' . now()->format('YmdHis') . '.pdf');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user' => 'required|string',
            'toko' => 'nullable|string',
            'items' => 'required|array',
            'items.*.nama' => 'required|string',
            'items.*.harga_grosir' => 'required|numeric|min:0',
            'items.*.jumlah' => 'required|integer|min:1',
            // Hapus items.*.total dari validasi karena akan dihitung ulang
        ]);
        // dd($validated);
        try {
            DB::beginTransaction();
            // Hitung ulang total di server
            $totalTransaksi = collect($validated['items'])->sum(function ($item) {
                return $item['harga_grosir'] * $item['jumlah'];
            });

            $transaksi = Transaksi::create([ // Perbaiki penulisan model
                'user' => $validated['user'],
                'toko' => $validated['toko'],
                'total' => $totalTransaksi,
            ]);

            foreach ($validated['items'] as $item) {
                TransaksiItem::create([
                    'transaksi_id' => $transaksi->id,
                    'nama_barang' => $item['nama'],
                    'harga_grosir' => $item['harga_grosir'],
                    'jumlah' => $item['jumlah'],
                    'total' => $item['harga_grosir'] * $item['jumlah'], // Hitung di server
                ]);
            }
            DB::commit();
            // dd($validated['items']);

            return redirect()->route('transaksi')->with('success', 'Barang berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(transaksi $transaksi)
    {
        //
    }
}
