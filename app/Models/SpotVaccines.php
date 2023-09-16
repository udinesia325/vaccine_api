<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpotVaccines extends Model
{
    use HasFactory;
    public $table = "spot_vaccines";

    function vaccines():BelongsTo {
        return $this->belongsTo(Vaccine::class);
    }
}
