<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trainer extends Model
{
    use Blameable;

    protected $guarded = ['id'];

    public function classes(): HasMany
    {
        return $this->hasMany(GymClass::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }   
}
