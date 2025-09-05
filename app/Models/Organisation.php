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
}
