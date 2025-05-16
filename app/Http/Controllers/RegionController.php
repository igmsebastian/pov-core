<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Group;

#[Group("01 - Region API Resources")]
class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getRegionList()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createRegion(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function getRegion(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateRegion(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteRegion(string $id)
    {
        //
    }
}
