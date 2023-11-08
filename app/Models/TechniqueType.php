<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechniqueType extends Model
{
    public function technique()
    {
        return $this->belongsTo('App\Models\Technique');
    }
    public function scopeActive($query)
    {
        return $query->where('active' , 1);
    }
    public function getActive()
    {
        return  $this->active == 1 ? 'فعال' : 'غير فعال';
    }

}
