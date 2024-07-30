<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemTypeRequest;
use App\Http\Requests\UpdateItemTypeRequest;
use Illuminate\Http\Request;
use App\Models\ItemType;
use Inertia\Inertia;
use Inertia\Response;


class ItemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list(Request $request): Response
    {
        //

        return Inertia::render('ItemTypes/List', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'name1'=>'JENRY '
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('ItemTypes/Create', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'name1'=>'JENRY'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemTypeRequest $storeItemRequest)
    {   
        return ($request->all());

        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'new_item' => 'required|string|max:255',
        // ]);

        // // Create a new data entrys
        // Data::create($request->all());

        // // Redirect or return a response
        // return redirect()->back()->with('success', 'Data submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
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
    public function update(UpdateItemTypeRequest $request, ItemType $itemType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemType $itemType)
    {
        //
    }
}
