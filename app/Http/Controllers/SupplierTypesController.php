<?php

namespace App\Http\Controllers;

use App\Http\Resources\SupplierListResource;
use App\Models\SupplierTypes;
use Illuminate\Http\Request;
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
    public function create(Request $request)
    {
        return Inertia::render('SupplierTypes/Create', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'form_type' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_type_name' => 'required|string|max:255',
        ]);

        $ItemType = new SupplierTypes();
        $ItemType->supplier_type_name = $request->input('supplier_type_name');
        $ItemType->save();

        return redirect()->route('suppliers-types')->with([
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'supplier_type_name' => $request->input('supplier_type_name'),
        ]);
    }

    public function show(Request $request)
    {
        $limit = $request->input('limit', 10);
        $search = $request->input('search', '');
        $page = $request->input('page', 1);

        $query = SupplierTypes::query();

        if (!empty($search)) {
            $query->where('supplier_type_name', 'like', '%' . $search . '%');
        }

        $supplierTypes = $query->paginate($limit, ['id', 'supplier_type_name'], 'page', $page);
        return SupplierListResource::collection($supplierTypes);

    }
    public function edit(Request $request, $id)
    {
        $search = $id;

        $query = SupplierTypes::query()
            ->select('id', 'supplier_type_name')
            ->where(function ($query) use ($search) {
                if (!empty($search)) {
                    $query->where('id', '=', $search);
                }
            });

        $item = $query->get();

        return Inertia::render('SupplierTypes/Create', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'form_type' => 'edit',
            'item_info' =>  $item[0]
        ]);
    }
    public function update(Request $request, $id)
    {
        $data = SupplierTypes::findOrFail($id);
        $validated = $request->validate([
            'supplier_type_name' => 'required|string|max:255',
        ]);
        $data->update($validated);

        $itemData = [
            'supplier_type_name' => $data->supplier_type_name,
        ];

        return redirect()->route('supplier-types')->with([
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'itemdata' => $itemData
        ]);
    }
    public function destroy(Request $request, $id)
    {
        $item = SupplierTypes::findOrFail($id);
        $itemData = [
            'supplier_type_name' => $item->supplier_type_name,
        ];
        $item->delete();

        return redirect()->route('supplier-types')->with([
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'item' => $itemData
        ]);
    }
}
