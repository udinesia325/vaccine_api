<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vaccinations extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    public $timestamps = false;

    public function spot(): BelongsTo
    {
        return $this->belongsTo(Spot::class);
    }

    public function vaccine(): BelongsTo
    {
        return $this->belongsTo(Vaccine::class);
    }

    public function medical(): BelongsTo
    {
        return $this->belongsTo(Medical::class);
    }
   
}
