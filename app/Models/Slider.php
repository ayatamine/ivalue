<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'title','subtitle', 'image','link', 'active' ,'created_at' , 'updated_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];
    public function scopeActive($query)
    {
        return $query->where('active' , 1);
    }
    public function getActive()
    {
        return  $this->active == 1 ? 'فعال' : 'غير فعال';
    }
    public function mainImage()
    {
        return $this->morphOne('App\Models\File', 'fileable', 'fileable_type', 'fileable_id')->where('type' , 'main');
    }
}
