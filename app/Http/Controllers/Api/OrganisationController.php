<?php

namespace App\Http\Controllers\Api;

use App\Dto\Organisation\QueryFilter;
use App\Http\Controllers\Controller;
use App\Services\OrganisationService;
use Illuminate\Database\Eloquent\Collection;

class OrganisationController extends Controller
{
    public function __construct(private OrganisationService $organisationService)
    {
    }

    /**
     * @param int $buildingId
     * @return Collection
     */
    public function getByBuildingId(int $buildingId): Collection
    {
        $queryFilter = new QueryFilter();
        $queryFilter->buildingId = $buildingId;

        return $this->organisationService->get($queryFilter);
    }

    /**
     * @param int $activityId
     * @return Collection
     */
    public function getByActivityId(int $activityId): Collection
    {
        $queryFilter = new QueryFilter();
        $queryFilter->activityId = $activityId;

        return $this->organisationService->get($queryFilter);
    }
}
