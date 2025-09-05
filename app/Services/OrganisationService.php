<?php

namespace App\Services;

use App\Dto\Organisation\QueryFilter;
use App\Models\Organisation;
use Illuminate\Database\Eloquent\Collection;

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
            $query->whereHas('activities', function ($query) use ($queryFilter) {
                $query->where('activities.id', $queryFilter->activityId);
            });
        }

        return $query->get();
    }
}
