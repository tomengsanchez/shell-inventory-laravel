<?php
namespace App\Http\Controllers;

use App\Http\Resources\ItemTypeListResource;
use Illuminate\Database\Console\Migrations\RefreshCommand;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemType;
use Inertia\Inertia;
use App\Http\Requests\UpdateItemRequest;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
            ->select('items.id', 'items.item_name', 'item_types.name as item_type_name')
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

        // return Inertia::render('ItemTypes/List', [
        //     'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
        //     'status' => session('status'),
        //     'req'=>$request['name']
        // ]);

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
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return Inertia::render('Items/List', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'id' => $request->input('id'),
            'item_name' => $request->input('item_name'),
            'item_type_id' => $request->input('item_type_id'),
        ]);
    }
}
