<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model implements Authenticatable
{
    use HasFactory;
    protected $table = "user";

    protected $guarded = ["id"];

    public function consultation(): HasMany
    {
        return $this->hasMany(Consultations::class);
    }

    public function regional(): BelongsTo
    {
        return $this->belongsTo(Regional::class);
    }

    public function getAuthIdentifierName()
    {
        return "name";
    }

    public function getAuthIdentifier()
    {
        return $this->name;
    }


    public function getAuthPassword()
    {
        return $this->password;
    }


    public function getRememberToken()
    {
        return $this->token;
    }


    public function setRememberToken($value)
    {
        return $this->token = $value;
    }

    function getRememberTokenName()
    {
        return "token";
    }
}
