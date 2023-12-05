<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notifiable;
use Cviebrock\EloquentSluggable\Sluggable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email','phone','active','password','created_at' , 'updated_at','membership_level'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', 'remember_token','created_at' , 'updated_at','active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function generateToken()
    {
        $this->api_token = Str::random(60);
        $this->save();
        return $this->api_token;
    }


    public function scopeActive($query)
    {
        return $query->where('active' , 1);
    }
    public function getActive()
    {
        return  $this->active == 1 ? 'فعال' : 'محظور';
    }
    public function estates()
    {
        return $this->hasMany('App\Models\Estate');
    }
    public function image()
    {
        return $this->belongsTo('App\Models\File','fileable_id')->where('type','image');
    }

    public function contract_image()
    {
        return $this->belongsTo('App\Models\File','fileable_id')->where('type','contract_image');
    }

    public function signature_image()
    {
        return $this->belongsTo('App\Models\File','fileable_id')->where('type','signature_image');
    }

//    custome attributes
    protected $appends = ['image_url','contract_image_url','signature_image_url' , 'member'];
    public function getMemberAttribute()
    {
       if($this->membership_level == 'admin') {
           return 'مشرف شامل';
       }elseif($this->membership_level == 'rater'){
           return 'مدير تقييم';
       }elseif($this->membership_level == 'client'){
           return 'عميل';
       }elseif($this->membership_level == 'entre'){
           return 'مدخل بيانات';
       }elseif($this->membership_level == 'coordinator'){
           return 'منسق';
       }elseif($this->membership_level == 'previewer'){
           return 'معاين';
       }elseif($this->membership_level == 'reviewer'){
           return 'مراجع';
       }
    }
    public function getImageUrlAttribute()
    {
        $image = File::where([['type' , 'image'],['fileable_id',$this->id]])->orderBy('id','desc')->first();
        if($image){
            return  URL::asset('pictures/users/'.$image->file);
        }
    }
    public function getContractImageUrlAttribute()
    {
        $image = File::where([['type' , 'contract_image'],['fileable_id',$this->id]])->orderBy('id','desc')->first();
        if($image){
            return  URL::asset('pictures/users/'.$image->file);
        }
    }
    public function getSignatureImageUrlAttribute()
    {
        $image = File::where([['type' , 'contract_image'],['fileable_id',$this->id]])->orderBy('id','desc')->first();
        if($image){
            return  URL::asset('pictures/users/'.$image->file);
        }
    }
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->membership_level =='client';
    }
}
