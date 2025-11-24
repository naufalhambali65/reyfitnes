<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Member extends Model
{
    use Blameable;
    protected $guarded = ['id'];
    protected $with = ['user'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function activeMembership(): HasOne
    {
        return $this->hasOne(MemberMembership::class)->where('status', 'active');
    }
    public function latestMembership(): HasOne
    {
        return $this->hasOne(MemberMembership::class)->latest('start_date');
    }

    public function memberMemberships(): HasMany
    {
        return $this->hasMany(MemberMembership::class);
    }

    public function getActiveMembershipNameAttribute()
{
    return $this->activeMembership?->membership->name;
}

    public function classBookings(): HasMany
    {
        return $this->hasMany(ClassBooking::class);
    }
}
