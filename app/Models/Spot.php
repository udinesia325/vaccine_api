<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PHPUnit\Framework\TestStatus\Risky;

class Spot extends Model
{
    use HasFactory;
    public $table = "spots";
    protected $guarded = ["id"];


    public function spot_vaccines() : HasMany {
        return $this->hasMany(SpotVaccines::class);
    }
    public function regional():BelongsTo {
        return $this->belongsTo(Regional::class);
    }
}
