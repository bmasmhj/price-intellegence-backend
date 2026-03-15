<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProduct extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'barcode', 'cost_price'];

    public function products()
    {
        return $this->hasMany(Product::class, 'user_product_id');
    }
}
