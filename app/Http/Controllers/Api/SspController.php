<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSspRequest;
use App\Http\Requests\UpdateSspRequest;
use App\Http\Resources\SspResource;
use App\Models\Ssp;
use App\Services\SspService;

class SspController extends Controller
{
    protected SspService $sspService;

    public function __construct()
    {
        $this->sspService = new SspService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Ssp::with(['dsps', 'campaigns'])->paginate(10);

        return SspResource::newCollection($models);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSspRequest $request)
    {
        $model = $this->sspService->make($request);
        return new SspResource($model);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $model = Ssp::with(['dsps', 'campaigns'])->findOrFail($id);

        return SspResource::make($model);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSspRequest $request, string $id)
    {
        return $this->sspService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->sspService->delete($id);
    }
}
