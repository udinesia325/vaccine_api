<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medical extends Model
{
    use HasFactory;
    public $table = "medical";
    
    function consultation():HasMany {
        return $this->hasMany(Consultations::class);
    }
}
