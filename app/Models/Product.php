<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Blameable;
    protected $guarded = ['id'];
    protected $with = ['category', 'unit'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function paymentItems()
    {
        return $this->morphMany(PaymentItem::class, 'item');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function unit()
    {
        return $this->belongsTo(ProductUnit::class, 'unit_id');
    }

    public function stockLogs()
    {
        return $this->hasMany(StockLog::class);
    }

    public function getPriceFormattedAttribute()
    {
        return 'Rp. ' . number_format($this->price, 2, ',', '.');
    }

    public function getCostFormattedAttribute()
    {
        return 'Rp. ' . number_format($this->cost, 2, ',', '.');
    }


}
