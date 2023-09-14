<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consultations extends Model
{
    use HasFactory;
    protected $table = "consultations";
    protected $guarded = ["id"];

    function medical():BelongsTo {
        return $this->belongsTo(Medical::class,"id","doctor_id");
    }
}
