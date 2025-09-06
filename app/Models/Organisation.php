<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 * @OA\Schema(
 *     schema="Organisation",
 *     type="object",
 *     title="Organisation",
 *     description="Organisation entity",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Unique identifier for the organisation"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the organisation"
 *     ),
 *     @OA\Property(
 *         property="building_id",
 *         type="integer",
 *         format="int64",
 *         description="ID of the building where the organisation is located"
 *     ),

 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Creation timestamp"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Last update timestamp"
 *     )
 * )
 *
 * @property int $id
 * @property string $name
 * @property PhoneNumber[] $phoneNumbers
 * @property int $building_id
 * @property Building $building
 */
class Organisation extends Model
{
    use HasFactory;

    /**
     * @return BelongsToMany
     */
    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class)->using(ActivityOrganisation::class);
    }

    /**
     * @return HasMany
     */
    public function phoneNumbers(): HasMany
    {
        return $this->hasMany(PhoneNumber::class);
    }

    /**
     * @return BelongsTo
     */
    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }
}
