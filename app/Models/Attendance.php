<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use Blameable;
    protected $guarded = ['id'];
    protected $with = ['member', 'membership'];

    protected $casts = [
    'check_in_at' => 'datetime',
];


    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function membership(): BelongsTo
    {
        return $this->belongsTo(MemberMembership::class, 'membership_id');
    }
}
