<?php

namespace App\Services;

use App\Dto\Organisation\QueryFilter;
use App\Models\Organisation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class OrganisationService
{
    /**
     * @param QueryFilter $queryFilter
     * @return Collection
     */
    public function get(QueryFilter $queryFilter): Collection
    {
        $query = Organisation::query();

        if ($queryFilter->buildingId) {
            $query->where('building_id', $queryFilter->buildingId);
        }

        if ($queryFilter->activityId) {
            $query->whereHas('activities', function (Builder $query) use ($queryFilter) {
                $query->where('activities.id', $queryFilter->activityId);
            });
        }

        if ($queryFilter->minLat !== null && $queryFilter->maxLat !== null && $queryFilter->maxLong !== null && $queryFilter->minLong !== null) {
            $query->whereHas('building', function (Builder $query) use ($queryFilter) {
                $query->whereBetween('lat', [$queryFilter->minLat, $queryFilter->maxLat]);
                $query->whereBetween('long', [$queryFilter->minLong, $queryFilter->maxLong]);
            });
        }

        return $query->get();
    }

    /**
     * @param int $organisationId
     * @return Model
     */
    public function show(int $organisationId): Model
    {
        return Organisation::query()->where('id', $organisationId)->with(['building', 'activities'])->firstOrFail();
    }
}
