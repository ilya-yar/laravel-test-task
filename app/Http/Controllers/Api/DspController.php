<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDspRequest;
use App\Http\Requests\UpdateDspRequest;
use App\Http\Resources\DspCollection;
use App\Http\Resources\DspResource;
use App\Models\Dsp;
use App\Services\DspService;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class DspController extends Controller
{
    protected DspService $dspService;

    public function __construct()
    {
        $this->dspService = new DspService();
    }

    /**
     * @return DspCollection
     *
     * @OA\Get(
     *     tags={"DSP"},
     *     path="api/dsp",
     *     operationId="indexDsp",
     *     method="GET",
     *     summary="Список DSP",
     *     security={{"userAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Список DSP",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 description="Список DSP",
     *                 type="array",
     *                 @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="name", type="string", example="DSP name"),
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(): DspCollection
    {
        $models = Dsp::paginate(10);

        return DspResource::newCollection($models);
    }

    /**
     * @OA\Post(
     *     tags={"DSP"},
     *     path="api/dsp",
     *     operationId="createDsp",
     *     method="POST",
     *     summary="Создание DSP",
     *     security={{"userAuth":{}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             ref="#/components/schemas/StoreDspRequest"
     *         )
     *     ),
     *    @OA\Response(
     *          response=201,
     *          description="Новая DSP",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/DspResource"
     *          )
     *    )
     * )
     * @param StoreDspRequest $request
     * @return DspResource
     */
    public function store(StoreDspRequest $request)
    {
        $model = Dsp::create($request->validated());
        return new DspResource($model);
    }

    /**
     * @OA\Get(
     *     tags={"DSP"},
     *     path="api/dsp/{id}",
     *     operationId="getSingleDSP",
     *     method="GET",
     *     summary="Получение DSP по Id",
     *     security={{"userAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="DSP",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 ref="#/components/schemas/DspResource"
     *             )
     *         )
     *     )
     * )
     * @return DspResource
     */
    public function show(int $id)
    {
        $model = Dsp::findOrFail($id);
        return DspResource::make($model);
    }

    /**
     * PUT Update the specified DSP.
     */

    /**
     * @return DspResource
     *
     * @OA\Put(
     *     tags={"DSP"},
     *     path="api/dsp",
     *     operationId="updateDSP",
     *     method="PUT",
     *     summary="Обновление DSP по Id",
     *     security={{"userAuth":{}}},
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              ref="#/components/schemas/UpdateDspRequest"
     *          )
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Обновленный DSP",
     *          @OA\JsonContent(
     *               ref="#/components/schemas/DspResource"
     *          )
     *     )
     * )
     */
    public function update(UpdateDspRequest $request, int $id): DspResource
    {
        $model = Dsp::findOrFail($id);
        $model->update($request->validated());
        return new DspResource($model);
    }

    /**
     * @return JsonResponse
     *
     * @OA\Delete (
     *     tags={"DSP"},
     *     path="api/dsp",
     *     operationId="deleteDSP",
     *     method="DELETE",
     *     summary="Удаление DSP по Id",
     *     security={{"userAuth":{}}},
     *     @OA\Response(
     *          response=204,
     *          description="Deletion successful",
     *     )
     * )
     */
    public function destroy(int $id)
    {
        return $this->dspService->delete($id);
    }
}
