<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends Model
{
    use Blameable;
    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getDisplayNameAttribute(): string
    {
        return "{$this->name} - {$this->account_number} a/n {$this->account_holder_name}";
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
