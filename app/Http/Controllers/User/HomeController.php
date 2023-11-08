<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Estate;
use Illuminate\Http\Request as Req;
use Illuminate\Support\Facades\Auth;
use Request;
use Response;
use App\User;


class HomeController extends Controller
{
    public function index()
    {
        try{
//            $estates = Estate::where('user_id' , Auth::user()->id)->active()->orderBy('id' , 'desc')->get();
            return view('frontend.home' );
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }
    public function darkmode()
    {
        $adID = Request::input('adID');
        $user= User::find($adID);
        if($user->dark_mode == 1){
            $user->dark_mode = 0;
            $user->save();
            return response()->json(['status' => 'light'], 500);
        }else{
            $user->dark_mode = 1;
            $user->save();
            return response()->json(['status' => 'dark'], 201);
        }
    }
}
