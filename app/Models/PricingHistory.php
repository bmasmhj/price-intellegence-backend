<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingHistory extends Model
{
    protected $table = 'pricing_history';
    public $timestamps = false;

    protected $fillable = [
        'product_id', 'price', 'rrp_price', 'concession_card_price',
        'private_price', 'price_change_percent', 'price_direction', 'created_at',
    ];

    protected $dates = ['created_at'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
