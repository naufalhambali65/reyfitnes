<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassBooking extends Model
{
    use Blameable;

    protected $guarded = ['id'];
    protected $with = ['member', 'class'];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(GymClass::class, 'gym_class_id');
    }
}
