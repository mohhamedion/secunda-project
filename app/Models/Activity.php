<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'parent_activity_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Activity::class, 'parent_activity_id');
    }
}
