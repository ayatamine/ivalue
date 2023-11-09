<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Arr;
use DB;

class Estate extends Model implements Auditable
{
    use Sluggable , \OwenIt\Auditing\Auditable;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    protected $auditInclude = [
        'name',
        'address',
        'floors_count',
        'apartments_count',
        'empty_apartments_count',
        'rented_apartments_count',
        'paid',
        'unpaid',
        'exports',
        'imports',
        'user_id',
        'city_id',
    ];
    protected $auditTimestamps = true;
    public function scopeActive($query)
    {
        return $query->where('active' , 1);
    }
    public function getActive()
    {
        return  $this->active == 1 ? 'فعال' : 'غير فعال';
    }
    public function user()
    {
        return $this->belongsTo('App\User' , 'user_id');
    }
    public function kind()
    {
        return $this->belongsTo('App\Models\Kind');
    }

    public function directions()
    {
        return $this->hasMany('App\EstateDirection');
    }
    public function payments()
    {
        return $this->hasMany('App\Models\EstatePayment');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    public function my_inputs()
    {
        return $this->hasMany('App\Models\EstateInput')->where('user_id' , auth()->user()->id);
    }
    public function inputs()
    {
        return $this->hasMany('App\Models\EstateInput');
    }
    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }
    public function reports()
    {
        return $this->hasMany('App\Models\Report','estate_id')->orderBy('id' , 'desc');
    }
    public function mainImage()
    {
        return $this->morphOne('App\Models\File', 'fileable', 'fileable_type', 'fileable_id')->where('type' , 'main');
    }

//    public function transformAudit(array $data): array
//    {
////        if (Arr::has($data, 'old_values.user_id')) {
////            $data['old_values']['user_name'] = User::find($this->getOriginal('user_id'))->name;
////            $data['new_values']['user_name'] = User::find($this->getAttribute('user_id'))->name;
////        }
////        if (Arr::has($data, 'old_values.user_id')) {
////            $data['old_values']['city_name'] = City::find($this->getOriginal('city_id'))->name;
////            $data['new_values']['city_name'] = City::find($this->getAttribute('city_id'))->name;
////        }
////        if (Arr::has($data, 'new_values.user_id')) {
////            $data['new_values']['user_name'] = User::find($this->getAttribute('user_id'))->name;
////        }
////        if (Arr::has($data, 'new_values.city_id')) {
////            $data['new_values']['city_name'] = City::find($this->getAttribute('city_id'))->name;
////        }
////        return $data;
//    }

    //    custome attributes
    protected $appends = ['image_url','file_urls','level_name'];
    public function getLevelNameAttribute()
    {
        $not = DashNotification::where('estate_id' , $this->id)->orderBy('id','desc')->first();
        if($not){
            if($not->user->membership_level == 'admin') {
                return 'مشرف شامل';
            }elseif($not->user->membership_level == 'rater'){
                return 'مقيم';
            }elseif($not->user->membership_level == 'rater_manager'){
                return 'مدير تقييم';
            }elseif($not->user->membership_level  == 'client'){
                return 'عميل';
            }elseif($not->user->membership_level  == 'entre'){
                return 'مدخل بيانات';
            }elseif($not->user->membership_level  == 'coordinator'){
                return 'منسق';
            }elseif($not->user->membership_level  == 'previewer'){
                return 'معاين';
            }elseif($not->user->membership_level  == 'reviewer'){
                return 'مراجع';
            }elseif($not->user->membership_level  == 'approver'){
                return 'المعتمد';
            }
        }else{
            return 'غير محدد';
        }
    }
    public function getImageUrlAttribute()
    {
        $image = File::where([['type' , 'main'],['fileable_id',$this->id]])->orderBy('id','desc')->first();
        if($image){
            return  \URL::asset('pictures/estates/'.$image->file);
        }
    }
    public function getFileUrlsAttribute()
    {
        $images = File::where([['type' , 'file'],['fileable_id',$this->id]])->orderBy('id','desc')->get();
        if($images->count() > 0){
            $imgs = [];
            foreach ($images as $image){
                 $imgs[] = \URL::asset('pictures/estates/'.$image->file);
            }
            return $imgs;
        }
    }
}
