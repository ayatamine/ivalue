<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Estate;
use App\Models\Media;
use App\Models\Moderator;
use App\Models\Question;
use App\Notification;
use App\User;
use Request;
use Response;

class AdminController extends Controller
{
    public function index()
    {
        return view('backend.home');
    }

    public function getestates()
    {
        $user_id = Request::input('user_id');
        $estates = Estate::where('user_id', $user_id)->get();
        return Response::json($estates);
    }
    /************ delete not *********/
    public function readNotification()
    {
        $notificationID = Request::input('notificationID');
        $notification = Notification::where('id', $notificationID)->first();
        $notification->delete();
        return response()->json(['status' => 'success'], 201);
    }
}
