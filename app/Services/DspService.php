<?php

namespace App\Services;

use App\Models\Dsp;
use App\Models\SspDsp;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DspService
{
    public function delete(string $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            /** @var Dsp $model */
            $model = Dsp::find($id);
            $model->delete();
            SspDsp::where('dsp_id', $id)->delete();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return response()->json(null, 204);
    }
}
