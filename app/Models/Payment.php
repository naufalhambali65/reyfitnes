<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    use Blameable;

    protected $guarded = ['id'];
    protected $with = ['bank', 'user'];
    protected $casts = [
    'amount' => 'integer',
    ];


    public function items(): HasMany
    {
        return $this->hasMany(PaymentItem::class);
    }

    public function memberMembership(): HasOne
    {
        return $this->hasOne(MemberMembership::class);
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
