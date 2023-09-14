<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    use HasFactory;
    public $table = "doctor";

    function consultations():HasMany {
        return $this->hasMany(Consultations::class);
    }
}
