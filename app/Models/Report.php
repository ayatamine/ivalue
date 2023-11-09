<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Cviebrock\EloquentSluggable\Sluggable;

class Report extends Model implements Auditable
{
    use Sluggable, \OwenIt\Auditing\Auditable;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    protected $auditInclude = [
        'flat',
        'floor',
        'name',
        'price',
        'color',
        'date',
        'estate_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function estate()
    {
        return $this->belongsTo('App\Models\Estate');
    }
    public function file()
    {
        return $this->morphOne('App\Models\File', 'fileable', 'fileable_type', 'fileable_id')->where('type' , 'main');
    }
    public function transformAudit(array $data): array
    {
        if (Arr::has($data, 'old_values.estate_id')) {
            $data['old_values']['estate_name'] = Estate::find($this->getOriginal('estate_id'))->name;
            $data['new_values']['estate_name'] = Estate::find($this->getAttribute('estate_id'))->name;
        }
        if (Arr::has($data, 'new_values.estate_id')) {
            $data['new_values']['estate_name'] = Estate::find($this->getAttribute('estate_id'))->name;
        }
        return $data;
    }
}
