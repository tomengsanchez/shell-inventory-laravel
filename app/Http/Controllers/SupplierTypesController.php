<?php

namespace App\Http\Controllers;

use App\Models\SupplierTypes;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSupplierTypesRequest;
use App\Http\Requests\UpdateSupplierTypesRequest;
use Inertia\Inertia;

class SupplierTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('SupplierTypes/List', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'data' => SupplierTypes::all()
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return Inertia::render('SupplierTypes/Create', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'form_type' => 'create',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_type_name' => 'required|string|max:255',
        ]);

        // Create a new item and save it to the database
        $ItemType = new SupplierTypes();
        $ItemType->supplier_type_name = $request->input('supplier_type_name');
        $ItemType->save();

        return redirect()->route('suppliers-types')->with([
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'supplier_type_name' => $request->input('supplier_type_name'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SupplierTypes $supplierTypes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupplierTypes $supplierTypes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierTypesRequest $request, SupplierTypes $supplierTypes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupplierTypes $supplierTypes)
    {
        //
    }
}
