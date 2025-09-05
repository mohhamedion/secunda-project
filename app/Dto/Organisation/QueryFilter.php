<?php

namespace App\Dto\Organisation;

class QueryFilter
{
    /**
     * @var int
     */
    public int $buildingId = 0;

    /**
     * @var int
     */
    public int $activityId = 0;

    /**
     * @var float|null
     */
    public ?float $minLat = null;

    /**
     * @var float|null
     */
    public ?float $maxLat = null;

    /**
     * @var float|null
     */
    public ?float $minLong = null;

    /**
     * @var float|null
     */
    public ?float $maxLong = null;
}
