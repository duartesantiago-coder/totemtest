<?php

namespace App\Http\Controllers;

use App\Models\Efemeride;
use App\Http\Requests\StoreEfemerideRequest;
use App\Http\Requests\UpdateEfemerideRequest;

class EfemerideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEfemerideRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEfemerideRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Efemeride  $efemeride
     * @return \Illuminate\Http\Response
     */
    public function show(Efemeride $efemeride)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Efemeride  $efemeride
     * @return \Illuminate\Http\Response
     */
    public function edit(Efemeride $efemeride)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEfemerideRequest  $request
     * @param  \App\Models\Efemeride  $efemeride
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEfemerideRequest $request, Efemeride $efemeride)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Efemeride  $efemeride
     * @return \Illuminate\Http\Response
     */
    public function destroy(Efemeride $efemeride)
    {
        //
    }
}
