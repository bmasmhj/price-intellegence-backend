<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScrapperLog extends Model
{
    public $timestamps = false;

    protected $table = 'scrapper_logs';

    protected $fillable = [
        'company_id', 'started_at', 'completed_at', 'status', 'message',
    ];

    protected $dates = ['started_at', 'completed_at'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
