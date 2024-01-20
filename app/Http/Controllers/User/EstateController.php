<?php

namespace App\Http\Controllers\User;

use App\Models\City;
use App\Models\Kind;
use App\Models\User;
use App\Models\Estate;
use App\Models\Country;
use App\Models\Category;
use App\Models\EstateInput;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Models\EstatePayment;
use App\Http\Controllers\Controller;
use App\Http\Requests\EstateRequest;
use App\Traits\DashNotificationTrait;
use App\Http\Requests\UpdateEstateRequest;

class EstateController extends Controller
{
    use UploadTrait, DashNotificationTrait;

    public function index()
    {
        try {
            $estates = Estate::whereDraftedBy(null)->get();
            return view('frontend.estates.index', compact('estates'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }
    public function archive()
    {
        try {
            $estates = Estate::where('archive' , 1)->get();
            return view('frontend.estates.archive', compact('estates'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }
    public function drafts()
    {
        try {
            $estates = Estate::where('drafted_by' , auth()->id())->get();
            return view('frontend.estates.drafts', compact('estates'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }


    public function estate_paid($subdomain,$estate_id)
    {
        try {
            $estate = Estate::find($estate_id);
            return view('frontend.estates.paid', compact('estate'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    public function create()
    {
        try {
            $cities = City::all();
            $countries = Country::all();
            $users = User::where('membership_level', 'client')->orWhereNull('membership_level')->get();
            $categories = Category::all();
            $kinds = Kind::all();
            return view('frontend.estates.create', compact('cities', 'users', 'categories', 'kinds', 'countries'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    public function estate_paid_post($subdomain,$estate_id,Request $request)
    {
        try {
             $estate = Estate::where('id', $estate_id)->first();

                $this->validate($request, [
                    'payment' => 'required',
                ]);
                // $inputs = EstateInput::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->get();
                // if ($inputs->count() > 0) {
                //     foreach ($inputs as $inp) {
                //         $inp->delete();
                //     }
                // }
                if(count($request->payment) > 0){
                    foreach($request->payment as $pay){
                        $payment = EstatePayment::find($pay);
                        $payment->done = 1;
                        $payment->save();
                    }
                }
//                $users = User::where('membership_level', 'client')->pluck('id');
//                $this->send_notification($users, '' . $estate->id . '', '#2E8B57', 'fa fa-user', 'طلب مراجعة الى صاحب المنشأة');
                // $users = User::where('membership_level', 'entre')->pluck('id');
                // $this->send_notification($users, '' . $estate->id . '', '#2E8B57', 'fa fa-user', 'اكمال عملية ادخال البيانات');

                // $input = new EstateInput();
                // $input->key = 'موافقة مدير المنشأة';
                // $input->value = 'موافقة';
                // $input->estate_id = $estate_id;
                // $input->user_id = auth()->user()->id;
                // $input->save();

                // DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();

                return redirect()->back()->with('done', 'تم ارسال عمليات الدفع بنجاح   ');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    public function store($subdomain,EstateRequest $request)
    {

        $estate = new Estate();
        $estate->name_arabic = $request->name_arabic;
        $estate->responsible_phone = $request->responsible_phone;
        $estate->floor = $request->floor;
        $estate->duration = $request->duration;
        $estate->duration_start = $request->duration_start;
        $estate->duration_end = $request->duration_end;
        $estate->evaluation_date = $request->evaluation_date;
        $estate->site_link =$request->site_link;
//            $estate->name_english = $request->name_english;
        $estate->address = $request->address;
        $estate->about = $request->about;
        $estate->land_size = $request->land_size;
        $estate->build_size = $request->build_size;
        $estate->age = $request->age ?: 1;
        $estate->level = $request->level;
        $estate->user_id = $request->user_id;
        $estate->category_id = $request->category_id;
        $estate->city_id = $request->city_id;
        $estate->kind_id = $request->kind_id;
        $estate->lat = $request->lat;
        $estate->lng = $request->lng;
        $estate->report_type = $request->report_type;
        $estate->code ='';

        if ($request->active) {
            $estate->active = 1;
        } else {
            $estate->active = 0;
        }
        if ($request->cancel) {
            $estate->drafted_by = auth()->id();
            $estate->draft_note = $request->draft_note;
        }
        $estate->entered_by =auth()?->id();
        $estate->save();
//            if ($request->hasFile('image')) {
//                $this->saveimage($request->image, 'pictures/estates', $estate->id , Estate::class, 'main');
//            }
        if ($request->file('files')) {
            $this->saveimages($request->file('files'), 'pictures/estates', $estate->id, Estate::class, 'file');
        }
        if ($request->reason) {
            $input = new EstateInput();
            $input->key = 'سبب التقييم';
            $input->value = $request->reason;
            $input->estate_id = $estate->id;
            $input->user_id = auth()->user()->id;
            $input->save();
        }
        if ($request->use) {
            $input = new EstateInput();
            $input->key = 'الاستخدام';
            $input->value = $request->use;
            $input->estate_id = $estate->id;
            $input->user_id = auth()->user()->id;
            $input->save();
        }
        if(!$request->report_type){
             return redirect()->back()->with('error' , 'يرجى اختيار المرحلة التالية');
        }
        if (!$request->cancel) {
        if($request->report_type == 'new'){
            $users = User::where('membership_level', 'rater_manager')->orWhereHas("roles", function ($q) {
                $q->where("name", "rater_manager");
            })->pluck('id');
            $this->send_notification($users, '' . $estate->id . '', '#4169E1', 'fa fa-eye', 'طلب جديد في مرحلة المراجعة');
        }elseif($request->report_type == 'old'){
            $users = User::where('membership_level', 'rater_manager')->orWhereHas("roles", function ($q) {
                $q->where("name", "rater_manager");
            })->pluck('id');
            $this->send_notification($users, '' . $estate->id . '', '#4169E1', 'fa fa-eye', 'طلب جديد في مرحلة المراجعة');
            // $users = User::where('membership_level', 'entre')->pluck('id');
            // $this->send_notification($users, '' . $estate->id . '', '#4169E1', 'fa fa-eye', '  تم الارسال لاكمال المدخلات');
        }else{
            return redirect()->back()->with('error' , 'يرجى اختيار المرحلة التالية');
        }
        }


        return redirect()->route('estates.index',$subdomain)->with('done', 'تم الاضافة بنجاح والارسال الى مدير التقييم ....');

    }

    public function show($subdomain,$slug)
    {
        $estate = Estate::where('slug', $slug)->first();
        if (isset($estate)) {
            return view('frontend.estates.show', compact('estate'));
        } else {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    public function calendar($subdomain,$slug)
    {
        $estate = Estate::where('slug', $slug)->first();
        if (isset($estate)) {
            return view('frontend.estates.calendar', compact('estate'));
        } else {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    public function edit($subdomain,$id)
    {
        $estate = Estate::where('id', $id)->first();
        if (isset($estate)) {
            $cities = City::all();
            $countries = Country::all();
            $users = User::where('membership_level', 'client')->orWhereNull('membership_level')->get();
            $categories = Category::all();
            $kinds = Kind::all();
            return view('frontend.estates.edit', compact('estate', 'cities', 'users', 'categories', 'kinds', 'countries'));
        } else {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    public function update($subdomain,UpdateEstateRequest $request, $id)
    {

        $estate = Estate::find($id);
        $estate->name_arabic = $request->name_arabic;
        $estate->name_english = $request->name_english;

        $estate->responsible_phone = $request->responsible_phone;
        $estate->floor = $request->floor;
        $estate->duration = $request->duration;
        $estate->duration_start = $request->duration_start;
        $estate->duration_end = $request->duration_end;
        $estate->evaluation_date = $request->evaluation_date;
        $estate->site_link =$request->site_link;

        $estate->address = $request->address;
        $estate->about = $request->about;
        $estate->land_size = $request->land_size;
        $estate->build_size = $request->build_size;
        $estate->age = $request->age ?: 1;
        $estate->level = $request->level;
        $estate->user_id = $request->user_id;
        $estate->category_id = $request->category_id;
        $estate->city_id = $request->city_id;
        $estate->kind_id = $request->kind_id;
        $estate->lat = $request->lat;
        $estate->lng = $request->lng;
        if ($request->active) {
            $estate->active = 1;
        } else {
            $estate->active = 0;
        }
        $estate->save();
//            if ($request->hasFile('image')) {
//                $this->saveimage($request->image, 'pictures/estates', $estate->id , Estate::class, 'main');
//            }
        if ($request->files) {
            $this->saveimages($request->files, 'pictures/estates', $estate->id, Estate::class, 'file');
        }
        if ($request->reason) {
            EstateInput::where('key', 'سبب التقييم')->where('estate_id', $estate->id)->where('user_id' , auth()->user()->id)->delete();
            $input = new EstateInput();
            $input->key = 'سبب التقييم';
            $input->value = $request->reason;
            $input->estate_id = $estate->id;
            $input->user_id = auth()->user()->id;
            $input->save();
        }
        if ($request->use) {
            EstateInput::where('key', 'الاستخدام')->where('estate_id', $estate->id)->where('user_id' , auth()->user()->id)->delete();
            $input = new EstateInput();
            $input->key = 'الاستخدام';
            $input->value = $request->use;
            $input->estate_id = $estate->id;
            $input->user_id = auth()->user()->id;
            $input->save();
        }
        return redirect()->route('estates.index',$subdomain)->with('done', 'تم التعديل بنجاح ....');

    }

    public function destroy($subdomain,$id)
    {
        try {
            $estate = Estate::find($id);
            $this->deleteimages($estate->id, 'pictures/estates/', Estate::class);
            $estate->delete();
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    public function delete_estates($subdomain)
    {
        try {
            $estates = Estate::all();
            if (count($estates) > 0) {
                foreach ($estates as $estate) {
                    $this->deleteimages($estate->id, 'pictures/estates/', Estate::class);
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

    public function log($subdomain,$slug)
    {
        try {
            $estate = Estate::where('slug', $slug)->first();
            $audits = $estate->audits;
            return view('frontend.estates.log', compact('audits', 'estate'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }
}
