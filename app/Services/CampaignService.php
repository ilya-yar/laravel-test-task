<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\SspCampaign;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CampaignService
{
    public function delete(string $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            /** @var Campaign $model */
            $model = Campaign::find($id);
            $model->delete();
            SspCampaign::where('campaign_id', $id)->delete();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return response()->json(null, 204);
    }
}
