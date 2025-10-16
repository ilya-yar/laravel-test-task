<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use App\Http\Resources\CampaignResource;
use App\Models\Campaign;
use App\Services\CampaignService;

class CampaignController extends Controller
{
    protected CampaignService $campaignService;

    public function __construct()
    {
        $this->campaignService = new CampaignService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Campaign::paginate(10);

        return CampaignResource::newCollection($models);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCampaignRequest $request)
    {
        $model = Campaign::create($request->validated());
        return new CampaignResource($model);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $model = Campaign::findOrFail($id);
        return CampaignResource::make($model);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCampaignRequest $request, string $id)
    {
        $model = Campaign::find($id);
        $model->update($request->validated());
        return new CampaignResource($model);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->campaignService->delete($id);
    }
}
