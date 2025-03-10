<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use App\Models\supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $supplier = Supplier::all();
        return view('barang.add',compact('supplier'));
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
                'nama' => 'required|string|max:255|unique:suppliers,nama', // Changed from barangs to suppliers
            ]);
    
            Supplier::create($validated);
    
            return redirect()->route('supplier')->with('success', 'Supplier berhasil ditambahkan');
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
    public function show(supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(supplier $supplier)
    {
        //
    }
}
