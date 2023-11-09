<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function estate()
    {
        return $this->belongsTo('App\Models\Estate');
    }
}
