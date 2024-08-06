<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreItemTypeRequest;
use App\Http\Requests\UpdateItemTypeRequest;
use Illuminate\Http\Request;
use App\Models\ItemType;
use Inertia\Inertia;
use Inertia\Response;
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

    public function list_table(Request $request)
    {
        return ItemTypeListResource::collection(ItemType::all());
        
        // Get pagination parameters
        // $limit = $request->input('limit', 10); // Default to 10 items per page

        // // Fetch paginated data
        // $itemTypes = ItemType::paginate($limit);

        // return redirect()->route('item-types-table')->with([
        //     'data' => ItemTypeListResource::collection(ItemType::all()),
        //     'totalItems' => $itemTypes->total(),
        //     'currentPage' => $itemTypes->currentPage(),
        //     'totalPages' => $itemTypes->lastPage(),
        // ]);
    }
    public function list(Request $request): Response
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

        // return redirect()->route('add-item-types')->with([
        //     'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
        //     'status' => session('status'),
        //     'item_create'=>'create'
        // ]);


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

        // return Inertia::render('ItemTypes/List', [
        //     'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
        //     'status' => session('status'),
        //     'req'=>$request['name']
        // ]);

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
