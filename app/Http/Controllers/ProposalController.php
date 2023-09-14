<?php

namespace App\Http\Controllers;

use App\Http\Requests\Proposal\ProposalRequest;
use App\Http\Resources\Proposal\ProposalResource;
use App\Http\Responses\ApiJsonResponse;
use App\Models\Proposal;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProposalRequest $request)
    {
        $proposal = Proposal::create([
            'user_id' => $request->user()->id,
            'body' => $request->body,
            'file' => $request->has('file') ? $request->file('file')->store('proposals', 'public') : null
        ]);

        NotificationService::notifyAdmin('Новое предложение.');

        return new ApiJsonResponse(
            data: new ProposalResource($proposal)
        );
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