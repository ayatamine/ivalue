<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Arr;

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
        return $this->belongsTo('App\User');
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
