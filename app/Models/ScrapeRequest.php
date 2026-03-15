<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScrapeRequest extends Model
{
    public $timestamps = false;

    protected $table = 'scrape_requests';

    protected $fillable = [
        'company_id', 'category', 'payload', 'params', 'headers', 'created_at',
    ];

    protected $dates = ['created_at'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
