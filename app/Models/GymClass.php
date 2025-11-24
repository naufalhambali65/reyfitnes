<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GymClass extends Model
{
    use Blameable;
    protected $guarded = ['id'];
    protected $with = ['category', 'trainer', 'membership'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ClassCategory::class);
    }

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Trainer::class);
    }

    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class);
    }

    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            Trainer::class,
            'id',
            'id',
            'trainer_id',
            'user_id'
        );
    }
}