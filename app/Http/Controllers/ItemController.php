<?php
namespace App\Http\Controllers;

use Illuminate\Database\Console\Migrations\RefreshCommand;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\ItemTypeListResource;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemType;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
    }

    public function DropdownItemTypes(Request $request)
    {
        return ItemTypeListResource::collection(ItemType::all());
    }
    public function listItemData(Request $request)
    {
        // Extract limit and search query from the request
        $limit = $request->input('limit', 10); // Default to 10 if not provided
        $search = $request->input('search', ''); // Default to empty string if not provided
        $page = $request->input('page', 1); // Default to 1 if not provided

        // Calculate offset for pagination
        $offset = ($page - 1) * $limit;

        // Build the query with joins
        $query = Item::query()
            ->join('item_types', 'items.item_type_id', '=', 'item_types.id')
            ->select('items.id', 'items.item_name', 'items.item_type_id', 'item_types.name as item_type_name')
            ->where(function ($query) use ($search) {
                if (!empty($search)) {
                    $query->where('items.item_name', 'like', '%' . $search . '%');
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
            'first_page_url' => url('/item-table-data?page=1'),
            'last_page' => $totalPages,
            'last_page_url' => url('/item-table-data?page=' . $totalPages),
            'next_page_url' => $page < $totalPages ? url('/item-table-data?page=' . ($page + 1)) : null,
            'prev_page_url' => $page > 1 ? url('/item-table-data?page=' . ($page - 1)) : null,
            'per_page' => $limit,
            'total' => $total,
        ];
        return response()->json($response);
    }
    public function create(Request $request)
    {
        return Inertia::render('Items/Create', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'form_type' => 'create',
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'item_type_id' => 'required|integer',
        ]);

        // Create a new item and save it to the database
        $ItemType = new Item();
        $ItemType->item_name = $request->input('item_name');
        $ItemType->item_type_id = $request->input('item_type_id');
        $ItemType->save();

        return redirect()->route('items')->with([
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'item_name' => $request->input('item_name'),
            'item_type_id' => $request->input('item_type_id'),
        ]);
    }
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = ItemType::findOrFail($id);
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'item_type_name' => 'required|string|max:255',
        ]);
        $data->update($validated);

        $itemData = [
            'item_name' => $data->name,
            'item_type_name' => $data->name,
        ];

        return redirect()->route('items')->with([
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'updatedName' => $itemData
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $itemData = [
            'item_name' => $item->item_name,
            'item_type_name' => $item->item_type_name,
        ];
        $item->delete();

        return redirect()->route('items')->with([
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'item' => $itemData
        ]);
    }

    public function itemShow(Request $request)
    {
        $search = $request->input('search', ''); // Default to empty string if not provided

        // Build the query with joins and where condition
        $query = Item::query()
            ->join('item_types', 'items.item_type_id', '=', 'item_types.id')
            ->select('items.id', 'items.item_name', 'items.item_type_id', 'item_types.name as item_type_name')
            ->where(function ($query) use ($search) {
                if (!empty($search)) {
                    $query->where('items.item_name', 'like', '%' . $search . '%');
                }
            });

        // Fetch the results without pagination
        $items = $query->get();

        // Prepare the response
        $response = [
            'data' => $items,
            'total' => $items->count(), // Total count of items fetched
        ];

        return response()->json($response);
    }
    public function itemEdit(Request $request, $id)
    {
        // Extract search query from the request
        $search = $id;

        // Build the query with joins
        
        $query = Item::query()
            ->join('item_types', 'items.item_type_id', '=', 'item_types.id')
            ->select('items.id', 'items.item_name', 'items.item_type_id', 'item_types.name as item_type_name')
            ->where(function ($query) use ($search) {
                if (!empty($search)) {
                    $query->where('items.id', '=', $search);
                }
            });

        // Fetch all results without limit or total count
        $item = $query->get();
        
        
        
        // Prepare response
        // $response = [
        //     'data' => $items,
        // ];

        // return response()->json($response);

        return Inertia::render('Items/Create', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'form_type' => 'edit',
            'item_info'=>$item[0]
        ]);
    }
}
