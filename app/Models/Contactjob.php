<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contactjob extends Model
{
    use SoftDeletes;

    protected $table = 'contactjobs';
    protected $dates = ['deleted_at'];
    protected $casts = ['c_share' => 'array'];
    protected $guarded = ['id'];

    // Relationships
    public function contact()
    {
        return $this->belongsTo('App\Models\Contact');
    }

    public function getImageAttribute()
    {
        return !empty($this->attributes['c_img']) ? 
                asset($this->attributes['c_img']) : 
                config('settings.no_img');
    }
}
