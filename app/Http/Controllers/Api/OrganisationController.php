<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrganisationRequest;
use App\Http\Requests\UpdateOrganisationRequest;
use App\Http\Resources\OrganisationResource;
use App\Models\Organisation;

class OrganisationController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Organisation::paginate(10);

        return OrganisationResource::newCollection($models);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrganisationRequest $request)
    {
        $model = Organisation::create($request->validated());
        return new OrganisationResource($model);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $model = Organisation::findOrFail($id);
        return OrganisationResource::make($model);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrganisationRequest $request, string $id)
    {
        $model = Organisation::find($id);
        $model->update($request->validated());
        return new OrganisationResource($model);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        /** @var Organisation $model */
        $model = Organisation::find($id);
        $model->delete();
    }
}
