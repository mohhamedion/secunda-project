<?php

namespace App\Http\Controllers\Api;

use App\Dto\Organisation\QueryFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrganisationIndexRequest;
use App\Services\OrganisationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *      title="Organisation API",
 *      version="1.0.0",
 *      description="API for managing and searching organisations"
 * )
 *
 * @OA\Tag(
 *     name="Organisations",
 *     description="API Endpoints for Organisations"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="ApiKeyAuth",
 *     type="apiKey",
 *     in="header",
 *     name="x-access-key",
 *     description="API Access Key",
 * )
 *
 *
 * @OA\Schema(
 *     schema="QueryFilter",
 *     type="object",
 *     description="Filter parameters for organisation search",
 *     @OA\Property(
 *         property="building_id",
 *         type="integer",
 *         example=1,
 *         description="ID of the building to filter organisations by"
 *     ),
 *     @OA\Property(
 *         property="activity_id",
 *         type="integer",
 *         example=5,
 *         description="ID of the activity type to filter organisations by"
 *     ),
 *     @OA\Property(
 *         property="min_lat",
 *         type="number",
 *         format="float",
 *         example=55.751244,
 *         description="Minimum latitude for geographical area filtering"
 *     ),
 *     @OA\Property(
 *         property="max_lat",
 *         type="number",
 *         format="float",
 *         example=55.761344,
 *         description="Maximum latitude for geographical area filtering"
 *     ),
 *     @OA\Property(
 *         property="min_long",
 *         type="number",
 *         format="float",
 *         example=37.618423,
 *         description="Minimum longitude for geographical area filtering"
 *     ),
 *     @OA\Property(
 *         property="max_long",
 *         type="number",
 *         format="float",
 *         example=37.628523,
 *         description="Maximum longitude for geographical area filtering"
 *     ),
 *     @OA\Property(
 *         property="organisation_name",
 *         type="string",
 *         example="Coffee Shop",
 *         description="Name or part of the name to search organisations by"
 *     )
 * )
 */
class OrganisationController extends Controller
{
    public function __construct(private OrganisationService $organisationService)
    {
    }

    /**
     * List organisations with filtering
     *
     * Cписок всех организаций находящихся в конкретном здании
     * Cписок всех организаций, которые относятся к указанному виду деятельности
     * Cписок организаций, которые находятся в заданном радиусе/прямоугольной области относительно указанной точки на карте
     * Поиск организации по названию
     *
     * @OA\Get(
     *     path="/api/organisations",
     *     summary="Get list of organisations with filtering",
     *     tags={"Organisations"},
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="building_id",
     *         in="query",
     *         description="Filter by building ID",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="activity_id",
     *         in="query",
     *         description="Filter by activity type ID",
     *         required=false,
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\Parameter(
     *         name="min_lat",
     *         in="query",
     *         description="Minimum latitude for area filter",
     *         required=false,
     *         @OA\Schema(type="number", format="float", example=55.751244)
     *     ),
     *     @OA\Parameter(
     *         name="max_lat",
     *         in="query",
     *         description="Maximum latitude for area filter",
     *         required=false,
     *         @OA\Schema(type="number", format="float", example=55.761344)
     *     ),
     *     @OA\Parameter(
     *         name="min_long",
     *         in="query",
     *         description="Minimum longitude for area filter",
     *         required=false,
     *         @OA\Schema(type="number", format="float", example=37.618423)
     *     ),
     *     @OA\Parameter(
     *         name="max_long",
     *         in="query",
     *         description="Maximum longitude for area filter",
     *         required=false,
     *         @OA\Schema(type="number", format="float", example=37.628523)
     *     ),
     *     @OA\Parameter(
     *         name="organisation_name",
     *         in="query",
     *         description="Search by organisation name",
     *         required=false,
     *         @OA\Schema(type="string", example="Coffee Shop")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Organisation")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function index(OrganisationIndexRequest $request): JsonResponse
    {
        $queryFilter = new QueryFilter();
        $queryFilter->buildingId = $request->input('building_id', 0);
        $queryFilter->activityId = $request->input('activity_id', 0);

        $queryFilter->minLat = $request->input('min_lat', null);
        $queryFilter->maxLat = $request->input('max_lat', null);
        $queryFilter->minLong = $request->input('min_long', null);
        $queryFilter->maxLong = $request->input('max_long', null);

        $queryFilter->organisationName = $request->input('organisation_name', null);

        return response()->json($this->organisationService->get($queryFilter));
    }

    /**
     * Get organisations by activity hierarchy
     *
     * Искать организации по виду деятельности. Например, поиск по виду деятельности «Еда»,
     * которая находится на первом уровне дерева, и чтобы нашлись все организации,
     * которые относятся к видам деятельности, лежащим внутри.
     * Т.е. в результатах поиска должны отобразиться организации с видом деятельности Еда, Мясная продукция, Молочная продукция.
     *
     * @OA\Get(
     *     path="/api/organisations/by-activity",
     *     summary="Get organisations by activity hierarchy",
     *     tags={"Organisations"},
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="activity_name",
     *         in="query",
     *         description="Name of the parent activity to search by",
     *         required=true,
     *         @OA\Schema(type="string", example="Food")
     *     ),
     *     @OA\Parameter(
     *         name="max_level",
     *         in="query",
     *         description="Maximum depth level in activity hierarchy to search",
     *         required=false,
     *         @OA\Schema(type="integer", example=3, default=3)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Organisation")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Activity name parameter is required"
     *     )
     * )
     */
    public function getByActivity(Request $request): JsonResponse
    {
        $activityName = $request->input('activity_name');
        $maxLevel = $request->input('max_level', 3);

        return response()->json($this->organisationService->getByActivity(
            activityName: $activityName,
            maxLevel: $maxLevel
        ));
    }

    /**
     * Get organisation by ID
     *
     * Вывод информации об организации по её идентификатору
     *
     * @OA\Get(
     *     path="/api/organisations/show/{organisationId}",
     *     summary="Get organisation by ID",
     *     tags={"Organisations"},
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="organisationId",
     *         in="path",
     *         description="ID of organisation to return",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Organisation")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Organisation not found"
     *     )
     * )
     */
    public function show(int $organisationId): JsonResponse
    {
        $organisation = $this->organisationService->show($organisationId);
        return response()->json($organisation);
    }
}
