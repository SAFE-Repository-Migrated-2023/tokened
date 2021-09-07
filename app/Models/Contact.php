<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'contacts';
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];
    protected $appends = ['image'];
    protected $casts = ['share' => 'array'];

    public function jobs()
    {
        return $this->hasMany('App\Models\Contactjob', 'contact_id');
    }

    public function educations()
    {
        return $this->hasMany('App\Models\Education', 'contact_id');
    }

    public function getNameAttribute()
    {
        return ucwords($this->attributes['name']);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }

    public function getImageAttribute()
    {
        return !empty($this->attributes['img']) ? 
                asset($this->attributes['img']) : 
                config('settings.no_img');
    }

}
