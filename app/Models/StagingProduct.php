<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StagingProduct extends Model
{
    protected $table = 'staging_products';

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
}
