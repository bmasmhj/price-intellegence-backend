<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'company_id', 'product_id', 'user_product_id', 'slug', 'sku', 'barcode',
        'name', 'description', 'price', 'rrp_price', 'concession_card_price',
        'private_price', 'price_change_percent', 'price_direction', 'url',
        'brand', 'category', 'sub_category', 'status', 'request_id',
        'payload', 'params', 'query_url', 'headers',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function userProduct()
    {
        return $this->belongsTo(UserProduct::class, 'user_product_id');
    }

    public function pricingHistory()
    {
        return $this->hasMany(PricingHistory::class, 'product_id');
    }
}
