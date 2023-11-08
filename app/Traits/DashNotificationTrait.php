<?php

namespace App\Traits;

use App\Models\DashNotification;
use App\Models\Notification;

Trait DashNotificationTrait
{
    function send_notification($user_ids , $estate_id  , $color , $icon , $title)
    {
        foreach($user_ids as $user_id){
            $not = new DashNotification();
            $not->title = $title;
            $not->user_id = $user_id;
            $not->color = $color;
            $not->icon = $icon;
            $not->estate_id = $estate_id;
            $not->save();
        }
    }
}
