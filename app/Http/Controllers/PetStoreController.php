<?php

namespace App\Http\Controllers;

use App\Models\PetStore;
use App\Http\Requests\StorePetStoreRequest;
use App\Http\Requests\UpdatePetStoreRequest;

class PetStoreController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePetStoreRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PetStore $petStore)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PetStore $petStore)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePetStoreRequest $request, PetStore $petStore)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PetStore $petStore)
    {
        //
    }
}
