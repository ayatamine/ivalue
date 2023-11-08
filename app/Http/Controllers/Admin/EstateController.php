<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EstateRequest;
use App\Models\City;
use App\Models\Estate;
use App\Traits\DashNotificationTrait;
use App\Traits\UploadTrait;
use App\User;
use Illuminate\Http\Request;
use NumberToWords\Legacy\Numbers\Words\Locale\Es;

class EstateController extends Controller
{
    use UploadTrait , DashNotificationTrait;
    public function index()
    {
        try {
            $estates = Estate::all();
            return view('backend.estates.index', compact('estates'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    public function create()
    {
        try {
            $cities = City::active()->get();
            $users = User::orderBy('id','desc')->get();
            return view('backend.estates.create',compact('cities','users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    public function store(EstateRequest $request)
    {

            $estate = new Estate();
            $estate->name = $request->name;
            $estate->address = $request->address;
            $estate->floors_count = $request->floors_count;
            $estate->apartments_count = $request->apartments_count;
            $estate->empty_apartments_count = $request->empty_apartments_count;
            $estate->rented_apartments_count = $request->rented_apartments_count;
            $estate->expected = $request->expected;
            $estate->user_id = $request->user_id;
            $estate->city_id = $request->city_id;
            if ($request->active) {
                $estate->active = 1;
            } else {
                $estate->active = 0;
            }
            $estate->save();
            if ($request->hasFile('image')) {
                $this->saveimage($request->image, 'pictures/estates', $estate->id , Estate::class, 'main');
            }

            $users = User::where('membership_level' , 'rater')->pluck('id');
            $this->send_notification($users, ''.$estate->id.'', '#4169E1' , 'fa fa-eye', 'طلب جديد في مرحلة المراجعة');

            return redirect()->route('estates.index')->with('done', 'تم الاضافة بنجاح ....');

    }

    public function show($slug)
    {
        $estate = Estate::where('slug',$slug)->first();
        if (isset($estate)) {
            return view('backend.estates.show', compact('estate'));
        } else {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }
    public function calendar($slug)
    {
        $estate = Estate::where('slug',$slug)->first();
        if (isset($estate)) {
            return view('backend.estates.calendar', compact('estate'));
        } else {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    public function edit($slug)
    {
        $estate = Estate::where('slug',$slug)->first();
        if (isset($estate)) {
            $cities = City::all();
            $users = User::orderBy('id','desc')->get();
            return view('backend.estates.edit', compact('estate','cities','users'));
        } else {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    public function update(EstateRequest $request, $id)
    {
        try {
            $estate = Estate::find($id);
            $estate->name = $request->name;
            $estate->address = $request->address;
            $estate->floors_count = $request->floors_count;
            $estate->apartments_count = $request->apartments_count;
            $estate->empty_apartments_count = $request->empty_apartments_count;
            $estate->rented_apartments_count = $request->rented_apartments_count;
            $estate->expected = $request->expected;
            $estate->user_id = $request->user_id;
            $estate->city_id = $request->city_id;
            if ($request->active) {
                $estate->active = 1;
            } else {
                $estate->active = 0;
            }
            $estate->save();
            if ($request->hasFile('image')) {
                $this->editimage($request->image, 'pictures/estates', $estate->id , Estate::class, 'main');
            }
            return redirect()->route('estates.index')->with('done', 'تم التعديل بنجاح ....');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    public function destroy($id)
    {
        try {
            $estate = Estate::find($id);
            $this->deleteimages($estate->id , 'pictures/estates/' , Estate::class);
            $estate->delete();
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }
    public function delete_estates()
    {
        try {
            $estates = Estate::all();
            if (count($estates) > 0) {
                foreach ($estates as $estate) {
                    $this->deleteimages($estate->id , 'pictures/estates/' , Estate::class);
                    $estate->delete();
                }
                return response()->json([
                    'success' => 'Record deleted successfully!'
                ]);
            } else {
                return response()->json([
                    'error' => 'NO Record TO DELETE'
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    public function log($slug)
    {
        try{
            $estate = Estate::where('slug' , $slug)->first();
            $audits = $estate->audits;
            return view('backend.estates.log', compact('audits' , 'estate'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }
}
