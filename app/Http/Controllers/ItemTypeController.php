<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemType;
use Inertia\Inertia;
use App\Http\Resources\ItemTypeListResource;

class ItemTypeController extends Controller
{

    public function index(Request $request)
    {
        return Inertia::render('ItemTypes/List', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'name1' => 'JENRY',
            'data' => ItemType::all()
        ]);
    }

    public function listTable(Request $request)
    {
        // Extract limit and search query from the request
        $limit = $request->input('limit', 10); // Default to 10 if not provided
        $search = $request->input('search', ''); // Default to empty string if not provided
        $page = $request->input('page', 1); // Default to 1 if not provided

        // Query the ItemType model
        $query = ItemType::query();

        // If there's a search input, apply filtering
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Paginate the results
        $itemTypes = $query->paginate($limit, ['id', 'name'], 'page', $page);
        // Return paginated results as JSON using the resource
        return ItemTypeListResource::collection($itemTypes);

        // return ItemTypeListResource::collection(ItemType::paginate($request['limit'], ['id', 'name'], 'Item Type', $request['page']));

    }
    public function list(Request $request)
    {
        return Inertia::render('ItemTypes/List', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'name1' => 'JENRY'
        ]);
    }
    public function create(Request $request)
    {
        return Inertia::render('ItemTypes/Create', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'item_create' => 'create'
        ]);

    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        // Create a new item and save it to the database
        $ItemType = new Itemtype();
        $ItemType->name = $request->input('name');
        $ItemType->save();

        return redirect()->route('item-types')->with([
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'req' => $request->input('name')
        ]);
    }

    public function show(ItemType $itemType)
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
            'name' => 'required|string|max:255',
        ]);
        $data->update($validated);

        $itemData = [
            'name' => $data->name
        ];

        return redirect()->route('item-types')->with([
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
        $item = ItemType::findOrFail($id);
        $itemData = [
            'id' => $item->id,
            'name' => $item->name
        ];
        $item->delete();

        return redirect()->route('item-types')->with([
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'item' => $itemData
        ]);
    }
}
