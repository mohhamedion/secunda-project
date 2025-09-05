<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $phone_number
 * @property int $building_id
 */
class Organisation extends Model
{
    use HasFactory;

    public function activities(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Activity::class)->using(ActivityOrganisation::class);
    }
}
