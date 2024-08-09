<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemTypeListResource;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemType;
use Inertia\Inertia;
use App\Http\Requests\StoreItemRequest;
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

    /**
     * Show the form for creating a new resource.
     */

     public function listItemTypes(Request $request)
    {
        return ItemTypeListResource::collection(ItemType::all());

    }
    public function create(Request $request)
    {
        return Inertia::render('Items/Create', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'item_create' => 'create'
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'item_types' => 'required|string|max:255'
        ]);

        // Create a new item and save it to the database
        $ItemType = new Item();
        $ItemType->item_name = $request->input('item_name');
        $ItemType->item_types = $request->input('item_types');
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
            'item_types' => $request->input('item_types'),

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
    public function destroy(Item $item)
    {
        //
    }
}
