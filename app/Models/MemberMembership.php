<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MemberMembership extends Model
{
    use Blameable;
    protected $guarded = ['id'];
    protected $with = ['member', 'membership', 'payment', 'user'];

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            Member::class,
            'id',
            'id',
            'member_id',
            'user_id'
        );
    }
}
