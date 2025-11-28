<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Membership extends Model
{
    use Blameable;

    protected $guarded = ['id'];

    protected $casts = [
    'price' => 'integer',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function paymentItems(): MorphMany
    {
        return $this->morphMany(PaymentItem::class, 'item');
    }

    public function gymClasses(): HasMany
    {
        return $this->hasMany(GymClass::class);
    }

    public function memberMemberships(): HasMany
    {
        return $this->hasMany(MemberMembership::class);
    }

    public function getPriceFormattedAttribute()
    {
        return 'Rp. ' . number_format($this->price, 2, ',', '.');
    }


}