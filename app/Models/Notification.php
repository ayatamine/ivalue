<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function estate()
    {
        return $this->belongsTo('App\Models\Estate');
    }
}
