<?php

namespace App\Services;

use App\Dto\Organisation\QueryFilter;
use App\Models\Organisation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

        if ($queryFilter->organisationName) {
            $query->where('name', 'LIKE', "%$queryFilter->organisationName%");
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

    /**
     * @param string $activityName
     * @param int $maxLevel
     * @return array
     */
    public function getByActivity(string $activityName, int $maxLevel): array
    {
        return DB::select("
        WITH RECURSIVE activity_tree AS (
            SELECT activities.id, activities.name, activities.parent_activity_id, 1 as level
            FROM activities
            WHERE activities.name = :activityName
            UNION ALL
            SELECT activities.id, activities.name, activities.parent_activity_id, atree.level + 1
            FROM activities
            INNER JOIN activity_tree atree ON activities.parent_activity_id = atree.id
            WHERE atree.level < :maxLevel
        )
        SELECT organisations.* FROM organisations
        INNER JOIN activity_organisation ON organisations.id = activity_organisation.organisation_id
        INNER JOIN activity_tree atree ON activity_organisation.activity_id = atree.id
    ", [
            'activityName' => $activityName,
            'maxLevel' => $maxLevel
        ]);
    }
}
