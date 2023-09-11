<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    use HasFactory;
    public $table = 'vaccines';
    public $primaryKey = "id";
    public $timestamps = true;
}
