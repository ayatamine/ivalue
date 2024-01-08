<?php

namespace App\Models;

use App\Models\Shared\BaseSharedModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Establishment extends  BaseSharedModel
{
    use HasFactory;
    protected $connection = 'shared';
    protected $guarded = [];
    public function admin() {
        return $this->belongsTo(User::class,'admin_id','id');
    }
}
