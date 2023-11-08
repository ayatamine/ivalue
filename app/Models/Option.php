<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = [
       'title', 'face', 'insta','whats' ,'phone' , 'active' , 'email','created_at' , 'updated_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    protected $appends = ['image_commercial_url','image_license_url','stamp_url','logo_url','header_url','footer_url',
        'cover_url' , 'background_url'];

    public function getImageCommercialUrlAttribute()
    {
        if($this->image_commercial){
            return  \URL::asset('pictures/settings/'.$this->image_commercial);
        }
        return null;
    }

    public function getImageLicenseUrlAttribute()
    {
        if($this->image_license){
            return  \URL::asset('pictures/settings/'.$this->image_license);
        }
        return null;
    }

    public function getStampUrlAttribute()
    {
        if($this->stamp){
            return  \URL::asset('pictures/settings/'.$this->stamp);
        }
        return null;
    }

    public function getLogoUrlAttribute()
    {
        if($this->logo){
            return  \URL::asset('pictures/settings/'.$this->logo);
        }
        return null;
    }

    public function getHeaderUrlAttribute()
    {
        if($this->header){
            return  \URL::asset('pictures/settings/'.$this->header);
        }
        return null;
    }
    public function getFooterUrlAttribute()
    {
        if($this->footer){
            return  \URL::asset('pictures/settings/'.$this->footer);
        }
        return null;
    }

    public function getBackgroundUrlAttribute()
    {
        if($this->background){
            return  \URL::asset('pictures/settings/'.$this->background);
        }
        return null;
    }

    public function getCoverUrlAttribute()
    {
        if($this->cover){
            return  \URL::asset('pictures/settings/'.$this->cover);
        }
        return null;
    }
}
