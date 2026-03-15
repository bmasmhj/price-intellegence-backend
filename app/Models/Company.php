<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['company_name', 'url', 'full_script', 'status'];

    protected $dates = ['deletedAt', 'last_scrapped', 'created_at', 'updated_at'];

    public function products()
    {
        return $this->hasMany(Product::class, 'company_id');
    }

    public function scrapperLogs()
    {
        return $this->hasMany(ScrapperLog::class, 'company_id');
    }

    public function scrapeRequests()
    {
        return $this->hasMany(ScrapeRequest::class, 'company_id');
    }
}
