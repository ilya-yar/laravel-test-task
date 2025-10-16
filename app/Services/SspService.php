<?php

namespace App\Services;

use App\Http\Requests\StoreSspRequest;
use App\Http\Requests\UpdateSspRequest;
use App\Http\Resources\SspResource;
use App\Models\Ssp;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SspService
{
    public function make(StoreSspRequest $request): Ssp
    {
        /** @var Ssp $model */
        $model = new Ssp($request->validated());

        DB::beginTransaction();
        try {
            $model->uuid = Ssp::generateUUID();
            $model->uid = Ssp::generateUID();
            $model->url = Ssp::generateUrl();
            $model->example_url = Ssp::generateExampleUrl();
            $model->save();
            $model->dsps()->sync($request->input('dsp_ids'));
            $model->campaigns()->sync($request->input('campaign_ids'));
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return $model;
    }

    public function update(UpdateSspRequest $request, string $id): SspResource
    {
        DB::beginTransaction();
        try {
            /** @var Ssp $model */
            $model = Ssp::find($id);
            $model->update($request->validated());
            $model->dsps()->sync($request->input('dsp_ids'));
            $model->campaigns()->sync($request->input('campaign_ids'));
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return new SspResource($model);
    }

    public function delete(string $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $model = Ssp::find($id);
            $model->dsps()->detach();
            $model->campaigns()->detach();
            $model->delete();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return response()->json(null, 204);
    }
}
