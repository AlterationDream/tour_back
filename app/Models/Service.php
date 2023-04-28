<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'active',
        'name',
        'services_category_id',
        'description',
        'price_value',
        'currency_id',
        'price_unit_id',
        'sale_tag_id',
        'country_id',
        'city_id',
        'images',
    ];
/*
    public function currency() {
        return $this->hasOne(Currency::class);
    }
    public function priceUnit() {
        return $this->hasOne(PriceUnit::class,);
    }
    public function saleTag() {
        return $this->hasOne(SaleTag::class);
    }
    public function country() {
        return $this->hasOne(Place::class);
    }
    public function city() {
        return $this->hasOne(Place::class);
    }*/
}
