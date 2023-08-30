<?php

namespace App\Http\Controllers;

use App\Http\Requests\UuidRequest;
use App\Http\Resources\Announce\AnnounceCollection;
use App\Http\Resources\Announce\AnnounceResource;
use App\Http\Responses\ApiJsonResponse;
use App\Models\Announce;
use Illuminate\Http\Request;

class AnnounceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UuidRequest $request)
    {
        if ($request->has('id')) {
            return new ApiJsonResponse(data: new AnnounceResource(Announce::findOrFail($request->id)));
        }

        return new AnnounceCollection(Announce::paginate(config('pagination.per_page')));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the main announce
     */
    public function getMain()
    {
        $announce = Announce::where('main', true)->firstOrFail();
        return new ApiJsonResponse(data: new AnnounceResource($announce));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}