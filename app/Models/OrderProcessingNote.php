<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProcessingNote extends Model
{
    use HasFactory;
    protected $fillable = [
        'path_type','step_number','estate_id', 'user_id','reason','note','created_at','updated_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
