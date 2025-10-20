<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Filters\OrganisationFilter;
use App\Http\Requests\OrganisationRequest;
use App\Http\Requests\StoreOrganisationRequest;
use App\Http\Requests\UpdateOrganisationRequest;
use App\Http\Resources\DspResource;
use App\Http\Resources\OrganisationCollection;
use App\Http\Resources\OrganisationResource;
use App\Models\Organisation;

class OrganisationController extends Controller
{
    private OrganisationFilter $filter;

    public function __construct(OrganisationRequest $request)
    {
        $this->filter = new OrganisationFilter($request);
    }

    /**
     * @OA\Get(
     *      tags={"Organisation"},
     *      path="api/organisation",
     *      operationId="indexOrganisation",
     *      method="GET",
     *      summary="Список организаций",
     *      security={{"userAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Список организаций",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  description="Список организаций",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/OrganisationResource")
     *              )
     *          )
     *      )
     *  )
     */
    public function index(): OrganisationCollection
    {
        $models = Organisation::filter($this->filter)->paginate(10);

        return OrganisationResource::newCollection($models);
    }

    /**
     * @OA\Post(
     *     tags={"Organisation"},
     *     path="api/organisation",
     *     operationId="createOrganisation",
     *     method="POST",
     *     summary="Создание организации",
     *     security={{"userAuth":{}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             ref="#/components/schemas/StoreOrganisationRequest"
     *         )
     *     ),
     *    @OA\Response(
     *          response=201,
     *          description="Новая организация",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/OrganisationResource"
     *          )
     *    )
     * )
     * @param StoreOrganisationRequest $request
     * @return OrganisationResource
     */
    public function store(StoreOrganisationRequest $request): OrganisationResource
    {
        $model = Organisation::create($request->validated());
        return new OrganisationResource($model);
    }

    /**
     * @OA\Get(
     *      tags={"Organisation"},
     *      path="api/organisation/{id}",
     *      operationId="getSingleOrganisation",
     *      method="GET",
     *      summary="Органищация",
     *      security={{"userAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Органищация",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  description="Органищация",
     *                  type="object",
     *                  ref="#/components/schemas/OrganisationResource"
     *              )
     *          )
     *      )
     *  )
     */
    public function show(int $id): OrganisationResource
    {
        $companies = Organisation::filter($this->filter)->findOrFail($id);
        return OrganisationResource::make($companies);
    }

    /**
     * @return DspResource
     *
     * @OA\Put(
     *     tags={"Organisation"},
     *     path="api/organisation",
     *     operationId="updateOrganisation",
     *     method="PUT",
     *     summary="Обновление организации по Id",
     *     security={{"userAuth":{}}},
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              ref="#/components/schemas/UpdateOrganisationRequest"
     *          )
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Обновленная организация",
     *          @OA\JsonContent(
     *               ref="#/components/schemas/OrganisationResource"
     *          )
     *     )
     * )
     */
    public function update(UpdateOrganisationRequest $request, string $id): OrganisationResource
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
