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
        
        return Inertia::render('ItemTypes/Create', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'req'=>$request['name']
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
    public function update(UpdateItemTypeRequest $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        
        $data = ItemType::findOrFail($id);
        $data->update($request->all());
        // return response()->json(['message' => 'Data updated successfully']);

        // $data = ItemType::find($id);
        // $data->name = $request->input('name');
        // $data->save();

        return Inertia::render('ItemTypes/List', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'req'=>$request['name']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemType $request, $id)
    {
        $data = ItemType::findOrFail($id);
        $data->delete();
        
        return Inertia::render('ItemTypes/List', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'req'=>$request['name']
        ]);
    }
}
