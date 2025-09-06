<?php

namespace App\Http\Controllers\Api;

use App\Dto\Organisation\QueryFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrganisationIndexRequest;
use App\Services\OrganisationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganisationController extends Controller
{
    public function __construct(private OrganisationService $organisationService)
    {
    }

    /**
     * @param OrganisationIndexRequest $request
     * @return JsonResponse
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
     * @param Request $request
     * @return JsonResponse
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
     * @param int $organisationId
     * @return JsonResponse
     */
    public function show(int $organisationId): JsonResponse
    {
        $organisation = $this->organisationService->show($organisationId);
        return response()->json($organisation);
    }
}
