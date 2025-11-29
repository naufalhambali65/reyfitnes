<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GymClass extends Model
{
    use Blameable;
    protected $guarded = ['id'];
    protected $with = ['category', 'trainer', 'membership'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function bookingClass(): HasMany
    {
        return $this->hasMany(ClassBooking::class, 'gym_class_id');
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
