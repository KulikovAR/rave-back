<?php

namespace App\Http\Controllers;

use App\Http\Requests\UuidRequest;
use App\Http\Resources\FaqTag\FaqTagCollection;
use App\Http\Resources\FaqTag\FaqTagResource;
use App\Http\Resources\FaqTag\FaqTagShowResource;
use App\Http\Responses\ApiJsonResponse;
use App\Models\FaqTag;
use Illuminate\Http\Request;

class FaqTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): FaqTagCollection
    {
        return new FaqTagCollection(FaqTag::orderBy('updated_at', 'desc')->paginate(config('pagination.per_page')));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UuidRequest $request)
    {
        return new ApiJsonResponse(
            data: new FaqTagShowResource(
                FaqTag::orderBy('updated_at', 'desc')->findOrFail($request->id)
            )
        );
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