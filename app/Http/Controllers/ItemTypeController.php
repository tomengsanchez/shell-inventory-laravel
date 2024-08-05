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
            'name1'=>'JENRY',
            'data' => ItemType::all()
        ]);
    }

    public function list_table(Request $request)
    {
        return ItemTypeListResource::collection(ItemType::all());
    }
    public function list(Request $request): Response
    {
        return Inertia::render('ItemTypes/List', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'name1'=>'JENRY'
        ]);
    }
    public function create(Request $request)
    {
        return Inertia::render('ItemTypes/Create', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'item_name'=>'JENRY'
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
    public function edit(ItemType $itemType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = ItemType::findOrFail($id);
        $data->update($request->all());

        $itemData = [
            'id' => $data->id,
            'name' => $data->name
        ];

        // No need to call $data->save() again because $data->update() already handles saving

        return redirect()->route('item-types')->with([
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),  // Ensure 'status' is defined in the session
            'updatedName' => $itemData['name']  // Access array value correctly
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $item = ItemType::findOrFail($id);
        $itemData = [
            'id'=> $item->id,
            'name'=> $item->name
        ];
        $item->delete();

        return redirect()->route('item-types')->with([
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'item'=>$itemData
        ]);
    }
}
