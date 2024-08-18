<?php

namespace App\Http\Controllers;
use App\Models\Supplier;
use App\Http\Resources\SupplierListResource;
use Illuminate\Http\Request;
use App\Models\SupplierTypes;
use Inertia\Inertia;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('Suppliers/List', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),

        ]);
    }
    public function DropdownSupplierTypes(Request $request)
    {
        return SupplierListResource::collection(SupplierTypes::all());
    }
    public function supplierListJson(Request $request)
    {
       // Extract limit and search query from the request
       $limit = $request->input('limit', 10); // Default to 10 if not provided
       $search = $request->input('search', ''); // Default to empty string if not provided
       $page = $request->input('page', 1); // Default to 1 if not provided

       // Calculate offset for pagination
       $offset = ($page - 1) * $limit;

       // Build the query with joins
       $query = Supplier::query()
           ->join('supplier_types', 'suppliers.supplier_type_id', '=', 'supplier_types.id')
           ->select('suppliers.id', 'suppliers.name',  'suppliers.address', 'suppliers.contact_number', 'suppliers.supplier_type_id', 'supplier_types.supplier_type_name as supplier_type_name')
           ->where(function ($query) use ($search) {
               if (!empty($search)) {
                   $query->where('suppliers.name', 'like', '%' . $search . '%');
               }
           });
       // Get the total count for pagination
       $total = $query->count();

       // Fetch paginated results
       $items = $query->offset($offset)
           ->limit($limit)
           ->get();

       // Calculate total pages
       $totalPages = ceil($total / $limit);

       // Prepare paginated response
       $response = [
           'current_page' => $page,
           'data' => $items,
           'first_page_url' => url('/supplier-table-data?page=1'),
           'last_page' => $totalPages,
           'last_page_url' => url('/supplier-table-data?page=' . $totalPages),
           'next_page_url' => $page < $totalPages ? url('/supplier-table-data?page=' . ($page + 1)) : null,
           'prev_page_url' => $page > 1 ? url('/supplier-table-data?page=' . ($page - 1)) : null,
           'per_page' => $limit,
           'total' => $total,
       ];
       return response()->json($response);
    }
    public function create(Request $request)
    {
        return Inertia::render('Suppliers/Create', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'form_type' => 'create',
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
            'supplier_type_id' => 'required|integer|max:255',
        ]);

        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->address = $request->address;
        $supplier->contact_number = $request->contact_number;
        $supplier->supplier_type_id = $request->supplier_type_id;

        $supplier->save();

        return Inertia::render('Suppliers/List', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'name' => $request->name,
            'address'=> $request->address,
            'contact_number'=> $request->contact_number,
            'supplier_type_id'=> $request->supplier_type_id,
        ]);
    }
    public function edit(Request $request,$id)
    {
         $search = $id;
         
         $query = Supplier::query()
             ->join('supplier_types', 'suppliers.supplier_type_id', '=', 'supplier_types.id')
             ->select('suppliers.id', 'suppliers.name',  'suppliers.address', 'suppliers.contact_number', 'suppliers.supplier_type_id', 'supplier_types.supplier_type_name as supplier_type_name')
             ->where(function ($query) use ($search) {
                 if (!empty($search)) {
                     $query->where('suppliers.id', '=', $search);
                 }
             });

         $item = $query->get();
 
         return Inertia::render('Suppliers/Create', [
             'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
             'status' => session('status'),
             'form_type' => 'edit',
             'item_info'=>$item[0]
         ]);
    }
    public function update(Request $request, $id)
    {
        $data = Supplier::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
            'supplier_type_id' => 'required|integer|max:255',
        ]);
        $data->update($validated);

        $itemData = [
            'name' => $data->name,
            'address' => $data->address,
            'contact_number' => $data->contact_number,
            'supplier_type_id' => $data->supplier_type_id,
        ];

        return redirect()->route('suppliers')->with([
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'itemdata' => $itemData
        ]);
    }
    public function destroy(Request $request, $id)
    {
        $item = Supplier::findOrFail($id);
        $itemData = [
            'name' => $item->name,
            'address' => $item->address,
            'contact_number' => $item->contact_number,
            'supplier_type_id' => $item->supplier_type_id,
        ];
        $item->delete();

        return redirect()->route('suppliers')->with([
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'item' => $itemData
        ]);
    }
}
