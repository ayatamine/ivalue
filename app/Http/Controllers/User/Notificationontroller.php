<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Estate;
use App\EstateDirection;
use App\Models\EstateInput;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Models\EstatePayment;
use App\Models\DashNotification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\DashNotificationTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Notificationontroller extends Controller
{
    use DashNotificationTrait, UploadTrait;

    public function not_open($not_id)
    {
        $last_rater = EstateInput::where('key', 'الأتعاب')->where('user_id', auth()->user()->id)->first();

        if (auth()->user()->membership_level == 'rater_manager') {
            $not = DashNotification::find($not_id);
            $estate = Estate::where('id', $not->estate_id)->first();
            return view('frontend.steps.rater_manager_page', compact('estate'));
        }

        if (auth()->user()->membership_level == 'manager') {
            $not = DashNotification::find($not_id);
            $estate = Estate::where('id', $not->estate_id)->first();
            return view('frontend.steps.manager_page', compact('estate'));
        }
        if (auth()->user()->membership_level == 'client') {
            $not = DashNotification::find($not_id);
            $estate = Estate::where('id', $not->estate_id)->first();
            return view('frontend.steps.client_page', compact('estate'));
        }

        if (auth()->user()->membership_level == 'entre') {
            $not = DashNotification::find($not_id);
            $estate = Estate::where('id', $not->estate_id)->first();
            return view('frontend.steps.entre_second_page', compact('estate'));
        }

        if (auth()->user()->membership_level == 'qima_approver') {
            $not = DashNotification::find($not_id);
            $estate = Estate::where('id', $not->estate_id)->first();
            return view('frontend.steps.qima_approver_page', compact('estate'));
        }

        if (auth()->user()->membership_level == 'coordinator') {
            $not = DashNotification::find($not_id);
            $estate = Estate::where('id', $not->estate_id)->first();
            $previewers = User::where('membership_level', 'previewer')->active()->get();
            $reviewers = User::where('membership_level', 'reviewer')->active()->get();
            $approvers = User::where('membership_level', 'approver')->active()->get();
            $raters = User::where('membership_level', 'rater')->active()->get();

            return view('frontend.steps.coordinator_page', compact('estate', 'previewers', 'reviewers', 'approvers', 'raters'));
        }

        if (auth()->user()->membership_level == 'previewer') {
            $not = DashNotification::find($not_id);
            if (!$not) {
                return redirect()->route('home');
            }
            $estate = Estate::where('id', $not->estate_id)->first();
            return view('frontend.steps.previewer_page', compact('estate'));
        }

        if (auth()->user()->membership_level == 'rater') {
            $not = DashNotification::find($not_id);
            $estate = Estate::where('id', $not->estate_id)->first();
            return view('frontend.steps.rater_page', compact('estate'));
        }

        if (auth()->user()->membership_level == 'reviewer') {
            $not = DashNotification::find($not_id);
            $estate = Estate::where('id', $not->estate_id)->first();
            return view('frontend.steps.reviewer_page', compact('estate'));
        }

        if (auth()->user()->membership_level == 'approver') {
            $not = DashNotification::find($not_id);
            $estate = Estate::where('id', $not->estate_id)->first();
            return view('frontend.steps.manager_page', compact('estate'));
        }
    }

    public function completeEntry($estate_id)
    {

        try {
            $not = DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->firstOrFail();
            //reactivate the estate
            $estate = Estate::where('id', $estate_id)->first();
            $estate->drafted_by = null;
            $estate->draft_note = null;
            $estate->save();
        } catch (\Exception $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return back()->with('error', 'لم يتم العثور على أي  مدخلات تخص هدا التقرير');
            }
            throw $ex;
        }
        return redirect()->route('not_open', ['not_id' => $not->id]);
    }
    public function level_refuse($estate_id, $type)
    {
        $estate = Estate::where('id', $estate_id)->first();
        $users = User::where('membership_level', 'coordinator')->pluck('id');
        $estate[$type] = 2;
        $estate[$type . '_reason'] = request()->reason;
        $estate->save();
        DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
        if ($type == 'reviewer') {
            $title = 'تم الرفض الطلب من قبل المراجع';
        } elseif ($type == 'approver') {
            $title = 'تم الرفض الطلب من قبل المتابع';
        } elseif ($type == 'previewer') {
            $title = 'تم الرفض الطلب من قبل المعاين';
        } elseif ($type == 'rater') {
            $title = 'تم الرفض الطلب من قبل المقيم';
        }
        $this->send_notification($users, '' . $estate->id . '', '#FF0000', 'fa fa-times', '' . $title . '');
        return redirect()->route('home')->with('done', 'تم الارسال الى المعاين لابلاغة بالرفض');
    }

    public function level_inputs($estate_id, Request $request)
    {
        try {

            DB::beginTransaction();
            $estate = Estate::where('id', $estate_id)->first();
            if (!$estate) {
                DB::rollBack();
                return redirect()->route('home')->with('done', 'عقار غير موجود');
            }

            if (auth()->user()->membership_level == 'rater_manager') {
                if ($request->cancel) {

                    $estate = Estate::where('id', $estate_id)->first();
                    $estate->drafted_by = auth()->id();
                    $estate->draft_note = $request->draft_note;
                    $estate->save();

                    $inputs = EstateInput::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->get();
                    if ($inputs->count() > 0) {
                        foreach ($inputs as $inp) {
                            $inp->delete();
                        }
                    }
                    //TODO:: add show/hide for notitication
                    // DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    DB::commit();
                    return redirect()->route('home')->with('done', 'تم الالغاء والحفظ كمسودة');
                }
                if ($request->return) {

                    $estate = Estate::where('id', $estate_id)->first();
                    //delete from draft if exists
                    $estate->drafted_by =null;
                    $estate->draft_note = $request->draft_note;
                    $estate->save();

                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();

                    $users = User::whereId($estate->user_id)->pluck('id');
                    if($estate->entered_by) $users = User::where('id', $estate->entered_by)->pluck('id');

                    $this->send_notification($users, '' . $estate->id . '', '#FF0000', 'fa fa-times',  'تم رفض الطلب من قبل مدير التفييم مع ملاحظات');


                    $inputs = EstateInput::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->get();
                    if ($inputs->count() > 0) {
                        foreach ($inputs as $inp) {
                            $inp->delete();
                        }
                    }
                    //TODO:: add show/hide for notitication
                    // DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    DB::commit();
                    return redirect()->route('home')->with('done', 'تم رفض الطلب وإعادته للادخال');
                }
                if ($estate->report_type == 'new') {
                    $this->validate($request, [
                        'works' => 'required',
                        'price' => 'required|numeric',
                        'qty' => 'required|numeric',
                    ]);
                }

                $estate = Estate::where('id', $estate_id)->first();

                $inputs = EstateInput::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->get();
                if ($inputs->count() > 0) {
                    foreach ($inputs as $inp) {
                        $inp->delete();
                    }
                }

                $input_works = new EstateInput();
                $input_works->key = 'نطاق العمل والاتعاب';
                $input_works->value = $request->works;
                $input_works->estate_id = $estate_id;
                $input_works->user_id = auth()->user()->id;
                $input_works->save();

                $input_works = new EstateInput();
                $input_works->key = 'العملة';
                $input_works->value = $request->currency;
                $input_works->estate_id = $estate_id;
                $input_works->user_id = auth()->user()->id;
                $input_works->save();
                if ($estate->report_type == 'new') {
                    $input_works = new EstateInput();
                    $input_works->key = 'مده العمل';
                    $input_works->value = $request->works_delay;
                    $input_works->estate_id = $estate_id;
                    $input_works->user_id = auth()->user()->id;
                    $input_works->save();

                    $price_value = $request->price / $request->qty;
                    for ($i = 0; $i < $request->qty; $i++) {
                        $input_price = new EstatePayment();
                        $input_price->price = $price_value;
                        $input_price->estate_id = $estate_id;
                        $input_price->save();
                    }
                    $input_works = new EstateInput();
                    $input_works->key = 'مدة عرض السعر';
                    $input_works->value = $request->price_delay;
                    $input_works->estate_id = $estate_id;
                    $input_works->user_id = auth()->user()->id;
                    $input_works->save();

                    $input_works = new EstateInput();
                    $input_works->key = 'اضافة اشتراطات وافتراضات خاصة';
                    $input_works->value = $request->special_order;
                    $input_works->estate_id = $estate_id;
                    $input_works->user_id = auth()->user()->id;
                    $input_works->save();
                }


                $input_works = new EstateInput();
                $input_works->key = 'عملة التقييم';
                $input_works->value = 'ريال سعودي';
                $input_works->estate_id = $estate_id;
                $input_works->user_id = auth()->user()->id;
                $input_works->save();

                $input_works = new EstateInput();
                $input_works->key = 'نوع التقرير';
                $input_works->value = $request->report_type;
                $input_works->estate_id = $estate_id;
                $input_works->user_id = auth()->user()->id;
                $input_works->save();

                $input_works = new EstateInput();
                $input_works->key = 'وصف التقرير';
                $input_works->value = $request->report_desc;
                $input_works->estate_id = $estate_id;
                $input_works->user_id = auth()->user()->id;
                $input_works->save();

                $input_works = new EstateInput();
                $input_works->key = 'اساس التقرير';
                $input_works->value = $request->report_main;
                $input_works->estate_id = $estate_id;
                $input_works->user_id = auth()->user()->id;
                $input_works->save();

                $input_works = new EstateInput();
                $input_works->key = 'فرضية القيمة';
                $input_works->value = $request->default_value;
                $input_works->estate_id = $estate_id;
                $input_works->user_id = auth()->user()->id;
                $input_works->save();


                $input_works = new EstateInput();
                $input_works->key = 'معايير التقييم';
                $input_works->value = $request->report_standards;
                $input_works->estate_id = $estate_id;
                $input_works->user_id = auth()->user()->id;
                $input_works->save();

                $input_works = new EstateInput();
                $input_works->key = 'مستخدم التقرير';
                $input_works->value = $request->report_users;
                $input_works->estate_id = $estate_id;
                $input_works->user_id = auth()->user()->id;
                $input_works->save();

                $input_works = new EstateInput();
                $input_works->key = 'نوع التقرير';
                $input_works->value = $request->report_kind;
                $input_works->estate_id = $estate_id;
                $input_works->user_id = auth()->user()->id;
                $input_works->save();





                DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                if ($estate->report_type == 'new') {
                    $users = User::where('membership_level', 'manager')->pluck('id');
                    $this->send_notification($users, '' . $estate->id . '', '#4B0082', 'fa fa-user-secret', 'طلب مراجعة الى مدير المنشأة');
                    DB::commit();

                    return redirect()->route('home')->with('done', 'تم الارسال الى مدير المنشأة بنجاح');
                } else {
                    $users = User::where('membership_level', 'entre')->pluck('id');
                    $this->send_notification($users, '' . $estate->id . '', '#4169E1', 'fa fa-eye', '  تم الارسال لاكمال المدخلات');
                    DB::commit();

                    return redirect()->route('home')->with('done', 'تم  الارسال الى مرحة الادخال ');
                }
            }
            if (auth()->user()->membership_level == 'manager') {
                $estate = Estate::where('id', $estate_id)->first();
                if ($request->accept == 1) {
                    // $this->validate($request, [
                    //     'payment' => 'required',
                    // ]);
                    // $inputs = EstateInput::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->get();
                    // if ($inputs->count() > 0) {
                    //     foreach ($inputs as $inp) {
                    //         $inp->delete();
                    //     }
                    // }
                    // if (count($request->payment) > 0) {
                    //     foreach ($request->payment as $pay) {
                    //         $payment = EstatePayment::find($pay);
                    //         $payment->done = 1;
                    //         $payment->save();
                    //     }
                    // }
                    //                $users = User::where('membership_level', 'client')->pluck('id');
                    //                $this->send_notification($users, '' . $estate->id . '', '#2E8B57', 'fa fa-user', 'طلب مراجعة الى صاحب المنشأة');
                    $users = User::where('membership_level', 'entre')->pluck('id');
                    $this->send_notification($users, '' . $estate->id . '', '#2E8B57', 'fa fa-user', 'اكمال عملية ادخال البيانات');

                    $input = new EstateInput();
                    $input->key = 'موافقة مدير المنشأة';
                    $input->value = 'موافقة';
                    $input->estate_id = $estate_id;
                    $input->user_id = auth()->user()->id;
                    $input->save();

                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    DB::commit();

                    return redirect()->route('home')->with('done', 'تم الارسال الى مرحلة ادخال باقي المعلومات');
                }
                if ($request->accept == 2) {
                    // $inputs = EstateInput::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->get();
                    // if ($inputs->count() > 0) {
                    //     foreach ($inputs as $inp) {
                    //         $inp->delete();
                    //     }
                    // }
                    $users = User::where('membership_level', 'rater_manager')->pluck('id');
                    $this->send_notification($users, '' . $estate->id . '', '#8B0000', 'fa fa-user', 'تم الارجاع الى مدخل البيانات');

                    $input = new EstateInput();
                    $input->key = 'موافقة مدير المنشأة';
                    $input->value = 'رفض';
                    $input->estate_id = $estate_id;
                    $input->user_id = auth()->user()->id;
                    $input->save();

                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    DB::commit();

                    return redirect()->route('home')->with('done', 'تم الارجاع الى مدخل البيانات');
                }
            }
            //        if (auth()->user()->membership_level == 'client') {
            //            $estate = Estate::where('id', $estate_id)->first();
            //            if ($request->accept == 1) {
            //                $inputs = EstateInput::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->get();
            //                if ($inputs->count() > 0) {
            //                    foreach ($inputs as $inp) {
            //                        $inp->delete();
            //                    }
            //                }
            //                $users = User::where('membership_level', 'entre')->pluck('id');
            //                $this->send_notification($users, '' . $estate->id . '', '#2E8B57', 'fa fa-user', 'اكمال عملية ادخال البيانات');
            //
            //                $input = new EstateInput();
            //                $input->key = 'موافقة العميل';
            //                $input->value = 'موافقة';
            //                $input->estate_id = $estate_id;
            //                $input->user_id = auth()->user()->id;
            //                $input->save();
            //
            //                DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
            //
            //                return redirect()->route('home')->with('done', 'تم الموافقة والارسال الى المرحلة التالية');
            //            }
            //            if ($request->accept == 2) {
            //                $inputs = EstateInput::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->get();
            //                if ($inputs->count() > 0) {
            //                    foreach ($inputs as $inp) {
            //                        $inp->delete();
            //                    }
            //                }
            //                $users = User::where('membership_level', 'manager')->pluck('id');
            //                $this->send_notification($users, '' . $estate->id . '', '#8B0000', 'fa fa-user', 'تم الرفض من العميل والارجاع الى مدير المنشأة');
            //
            //                $input = new EstateInput();
            //                $input->key = 'موافقة  العميل';
            //                $input->value = 'رفض';
            //                $input->estate_id = $estate_id;
            //                $input->user_id = auth()->user()->id;
            //                $input->save();
            //
            //                DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
            //
            //                return redirect()->route('home')->with('done', 'تم الارجاع الى مدير المنشأة');
            //            }
            //        }

            if (auth()->user()->membership_level == 'entre') {
                $estate = Estate::where('id', $estate_id)->first();
                if ($request->land_size) {
                    $estate->land_size = $request->land_size;
                }
                if ($request->build_size) {
                    $estate->build_size = $request->build_size;
                }
                $estate->save();
                $price_list = [];
                $price_list = $request->infos;
                $limit_list = $request->limit;
                foreach ($price_list as $key => $price) {
                    if ($price['value']) {
                        $input = new EstateInput();
                        $input->key = $price['key'];

                        if (is_array($price['value'])) {
                            $input->value = implode(' / ', $price['value']);
                        } else {
                            $input->value = $price['value'];
                        }


                        $input->estate_id = $estate_id;
                        $input->user_id = auth()->user()->id;
                        $input->save();
                    }
                }

                foreach ($limit_list as $price) {
                    $limit = new EstateDirection();
                    $limit->direction = $price['direction'];
                    $limit->limit = $price['limit'];
                    $limit->length = $price['length'];
                    $limit->estate_id = $estate_id;
                    $limit->save();
                }
                if ($request->file('files')) {
                    $this->saveimages($request->file('files'), 'pictures/estates', $estate->id, Estate::class, 'file');
                }
                $users = User::where('membership_level', 'coordinator')->pluck('id');
                DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                $this->send_notification($users, '' . $estate->id . '', '#00FA9A', 'fa fa-user', 'اكمال عملية التنسيق لاكمال باقي المراحل');
                DB::commit();
                return redirect()->route('home')->with('done', 'تم الارسال الى المنسق لاكمال باقي المراحل');
            }

            if (auth()->user()->membership_level == 'previewer') {
                $estate = Estate::where('id', $estate_id)->first();
                $price_list = [];
                $price_list = $request->infos;
                foreach ($price_list as $key => $price) {
                    if ($price['value'] && $price['key']) {
                        $input = new EstateInput();
                        $input->key = $price['key'];

                        if (is_array($price['value'])) {
                            $input->value = implode(' / ', $price['value']);
                        } else {
                            $input->value = $price['value'];
                        }


                        $input->estate_id = $estate_id;
                        $input->user_id = auth()->user()->id;
                        $input->save();
                    }
                }
                if ($request->file('files')) {
                    $this->saveimages($request->file('files'), 'pictures/estates', $estate->id, Estate::class, 'file');
                }
                $users = User::where('id', $estate->rater_id)->pluck('id');
                DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                $this->send_notification($users, '' . $estate->id . '', '#FFFF2E', 'fa fa-star', 'اكمال عملية التنسيق لاكمال باقي المراحل');
                DB::commit();
                return redirect()->route('home')->with('done', 'تم الارسال الى المقيم لاكمال باقي المراحل');
            }

            if (auth()->user()->membership_level == 'rater') {

                if (!$request->assessment) {
                    return redirect()->back()->with('done', 'يرجى اختيار اسلوب التقييم');
                }

                $estate = Estate::where('id', $estate_id)->first();

                $price_list = [];
                $price_list = $request->infos;
                if ($price_list && count($price_list) > 0) {
                    foreach ($price_list as $price) {
                        $input = new EstateInput();
                        $input->key = $price['key'];
                        $input->value = $price['value'];
                        $input->estate_id = $estate_id;
                        $input->user_id = auth()->user()->id;
                        $input->save();
                    }
                }


                if ($request->file('files')) {
                    $this->saveimages($request->file('files'), 'pictures/estates', $estate->id, Estate::class, 'file');
                }
                $users = User::where('id', $estate->reviewer_id)->pluck('id');
                DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                $this->send_notification($users, '' . $estate->id . '', '#DB7093	', 'fa fa-eye', 'اكمال عملية المراجعة لاكمال باقي المراحل');
                DB::commit();
                if ($request->assessment) {

                    session()->put('estate_id', $estate->id);
                    session()->put('from', 'rater');
                    // return session()->all();
                }
                if ($request->assessment == 'investment') {

                    return redirect()->route('investments.create');
                }
                if ($request->assessment == 'land') {
                    return redirect()->route('land.create');
                }
                if ($request->assessment == 'parking') {
                    return redirect()->route('parking.create');
                }
                if ($request->assessment == 'petrol') {
                    return redirect()->route('petrol_station.create');
                }
                if ($request->assessment == 'estate') {
                    return redirect()->route('build.create');
                }
                if ($request->assessment == 'farm') {
                    return redirect()->route('farm.create');
                }
                // return redirect()->route('home')->with('done', 'تم الارسال الى المراجع لاكمال باقي المراحل');
            }

            if (auth()->user()->membership_level == 'reviewer') {
                $estate = Estate::where('id', $estate_id)->first();
                if ($request->accept == 1) {
                    $users = User::where('membership_level', 'approver')->pluck('id');
                    //            $users = User::where('id', $estate->user_id)->pluck('id');
                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    $this->send_notification($users, '' . $estate->id . '', '#40E0D0', 'fa fa-user', 'الاطلاع على المعطيات والاءسال للعميل');
                    DB::commit();
                    return redirect()->route('home')->with('done', 'تم الارسال الى المعتمد والمراجعة');
                } elseif ($request->accept == 2) {
                    $users = User::where('membership_level', 'rater')->pluck('id');
                    //            $users = User::where('id', $estate->user_id)->pluck('id');
                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    $this->send_notification($users, '' . $estate->id . '', '#40E0D0', 'fa fa-user', 'عملية رفض على ما تم تقييمة');
                    DB::commit();
                    return redirect()->route('home')->with('done', 'تم الارسال الى المقيم مرة اخرى');
                } elseif ($request->accept == 3) {
                    $users = User::where('membership_level', 'coordinator')->pluck('id');
                    //            $users = User::where('id', $estate->user_id)->pluck('id');
                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    $this->send_notification($users, '' . $estate->id . '', '#40E0D0', 'fa fa-user', 'عملية رفض   وتم الارسال الى المنسق ');
                    DB::commit();
                    return redirect()->route('home')->with('done', 'تم الارسال الى المنسق مرة اخرى');
                }
            }

            if (auth()->user()->membership_level == 'coordinator') {
                $this->validate($request, [
                    'reviewer_id' => 'required|numeric',
                    'approver_id' => 'required|numeric',
                    'perviewer_id' => 'required|numeric',

                    'perviewer_date' => 'required',
                    // 'rater_date' => 'required|numeric',
                    'reviewer_date' => 'required',
                    'approver_date' => 'required',
                ]);

                $estate = Estate::where('id', $estate_id)->first();
                $users = User::where('id', $request->perviewer_id)->pluck('id');
                $estate->reviewer_id = $request->reviewer_id;
                $estate->approver_id = $request->approver_id;
                $estate->rater_id = $request->rater_id;

                $estate->perviewer_date = $request->perviewer_date;
                $estate->reviewer_date = $request->reviewer_date;
                $estate->approver_date = $request->approver_date;
                $estate->rater_date = $request->rater_date;

                $estate->reviewer = $estate->reviewer == 2 ? 0 : $estate->reviewer;
                $estate->approver = $estate->approver == 2 ? 0 : $estate->approver;
                $estate->previewer = $estate->previewer == 2 ? 0 : $estate->previewer;
                $estate->rater = $estate->rater == 2 ? 0 : $estate->rater;
                $estate->save();
                DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                $this->send_notification($users, '' . $estate->id . '', '#D18700', 'fa fa-eye', 'يرجى المراجعة لاكمال باقي المراحل');
                DB::commit();
                return redirect()->route('home')->with('done', 'تم الارسال الى المعاين لاكمال باقي المراحل');
            }
            if (auth()->user()->membership_level == 'approver') {
                $estate = Estate::where('id', $estate_id)->first();
                if ($request->accept == 1) {
                    $estate->archive = 1;
                    // $estate->qema = $request->qema_code;
                    $estate->save();
                    // $input = new EstateInput();
                    // $input->key = 'رقم التسجيل في قيمة';
                    // $input->value = $request->qema_code ?: '1';
                    // $input->estate_id = $estate_id;
                    // $input->user_id = auth()->user()->id;
                    // $input->save();

                    try {
                        DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                        $users = User::where('membership_level', 'qima_approver')->pluck('id');
                        //            $users = User::where('id', $estate->user_id)->pluck('id');
                        $this->send_notification($users, '' . $estate->id . '', '#000', 'fa fa-user', 'تم الارسال الى معتمد قيمة');
                    } catch (\Exception $e) {
                    }
                    DB::commit();

                    return redirect()->route('home')->with('done', 'تمت الموافقة والارسال الى مراجع قيمة ');
                }
                if ($request->accept == 2) {
                    // $inputs = EstateInput::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->get();
                    // if ($inputs->count() > 0) {
                    //     foreach ($inputs as $inp) {
                    //         $inp->delete();
                    //     }
                    // }
                    $users = User::where('membership_level', 'rater_manager')->pluck('id');
                    $this->send_notification($users, '' . $estate->id . '', '#8B0000', 'fa fa-user', 'تم الارجاع الى مدخل البيانات');

                    $input = new EstateInput();
                    $input->key = 'موافقة الاعتماد ';
                    $input->value = 'رفض';
                    $input->estate_id = $estate_id;
                    $input->user_id = auth()->user()->id;
                    $input->save();

                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    DB::commit();

                    return redirect()->route('home')->with('done', 'تم الارجاع الى مدخل البيانات');
                }
            }
            if (auth()->user()->membership_level == 'qima_approver') {
                $estate = Estate::where('id', $estate_id)->first();

                $estate->qema = $request->qema_code;
                $estate->save();
                $input = new EstateInput();
                $input->key = 'رقم التسجيل في قيمة';
                $input->value = $request->qema_code ?: '1';
                $input->estate_id = $estate_id;
                $input->user_id = auth()->user()->id;
                $input->save();

                try {
                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                } catch (\Exception $e) {
                }
                DB::commit();

                return redirect()->route('home')->with('done', 'تمت الموافقة والارسال الى الارشيف ');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // return $request->infos;
            return redirect()->back()->with('error', ' من فضلك قم بملئ جميع الحقول');
        }
    }

    public function edit_archive($estate_id)
    {
        try {
            $estate = Estate::where('id', $estate_id)->first();
            $inputs = \DB::table('estate_inputs')->where('estate_id', $estate_id)->get();
            return view('frontend.estates.edit_archive', compact('estate', 'inputs'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', ' يوجد مشكلة يرجى التواصل مع صاحب الخدمة');
        }
    }

    public function edit_archive_post($estate_id, Request $request)
    {
        try {
            DB::beginTransaction();
            $estate = Estate::where('id', $estate_id)->first();
            $inputs = EstateInput::where('estate_id', $estate_id)->get();
            foreach ($inputs as $key => $input) {
                $input->value = $request->input("req." . $key . "");
                $input->save();
            }
            DB::commit();
            return redirect()->route('home')->with('done', 'تمت التعديل  بنجاح  ');
        } catch (\Exception $e) {
            DB::rollBack();
            // return $request->infos;
            return redirect()->back()->with('error', ' من فضلك قم بملئ جميع الحقول');
        }
    }
}
