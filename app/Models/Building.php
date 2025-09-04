<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $address
 * @property float $long
 * @property float $lat
 */
class Building extends Model
{
    use HasFactory;
}
