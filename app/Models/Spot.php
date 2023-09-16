<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Spot extends Model
{
    use HasFactory;
    public $table = "spots";

    public function spot_vaccines() : HasMany {
        return $this->hasMany(SpotVaccines::class);
    }
}
