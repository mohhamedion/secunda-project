<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $parent_activity_id
 */
class Activity extends Model
{
    use HasFactory;

    public function organisations(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Organisation::class)->using(ActivityOrganisation::class);
    }
}
