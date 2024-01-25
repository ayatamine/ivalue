<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name','zone_id', 'active' ,'created_at' , 'updated_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at','zone_id',
    ];
    public function scopeActive($query)
    {
        return $query->where('active' , 1);
    }
    public function getActive()
    {
        return  $this->active == 1 ? 'فعال' : 'غير فعال';
    }
    public function zone()
    {
        return $this->belongsTo('App\Models\Zone');
    }
}
