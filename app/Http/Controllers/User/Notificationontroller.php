<?php

namespace App\Http\Controllers\User;

use App\Models\City;
use App\Models\User;
use App\Models\Zone;
use App\Models\Estate;
use App\Models\Country;
use App\Models\EstateInput;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Models\EstatePayment;
use App\Models\EstateDirection;
use App\Models\DashNotification;
use Illuminate\Support\Facades\DB;
use App\Models\OrderProcessingNote;
use App\Http\Controllers\Controller;
use App\Traits\DashNotificationTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Notificationontroller extends Controller
{
    use DashNotificationTrait, UploadTrait;

    public function not_open($subdomain, $not_id)
    {
        // $last_rater = EstateInput::where('key', 'الأتعاب')->where('user_id', auth()->user()->id)->first();

        if (auth()->user()->membership_level == 'rater_manager' || auth()->user()->hasRole('rater_manager')) {
            $not = DashNotification::find($not_id);
            // $estate = Estate::with('files','directions','payments','category:id,name','kind:id,name','user:id,name')->where('id', $not->estate_id)->first();
            $estate = Estate::where('id', $not->estate_id)->first();
            return view('frontend.steps.rater_manager_page', compact('estate'));
        }

        if (auth()->user()->membership_level == 'manager' || auth()->user()->hasRole('manager')) {
            $not = DashNotification::find($not_id);
            $estate = Estate::where('id', $not->estate_id)->first();
            return view('frontend.steps.manager_page', compact('estate'));
        }
        if (auth()->user()->membership_level == 'client') {
            $not = DashNotification::find($not_id);
            $estate = Estate::where('id', $not->estate_id)->first();

            // if ($not->current_step == 6) //الموافقة او الرفض على السعر المعتمد من طرف مدير المنشأة
            // {
            return view('frontend.steps.client_page_step6', compact('estate'));
            // }
            // return view('frontend.steps.client_page', compact('estate'));
        }

        if (auth()->user()->membership_level == 'entre' || auth()->user()->hasRole('enter')) {
            $not = DashNotification::find($not_id);
            $estate = Estate::
                // with(['inputs'=>function($query){
                //      $query->whereIn('key',['عنوان التقرير','اسم المالك','نسبة المالك','نوع وثيقة التملك','مصدر الوثيقة','رقم الوثيقة','تاريخ اصدارها',
                //     'نوع الملكية','رقم العقار','رقم قطعة الارض','رقم المخطوط','القيود على العقار',
                //     'عدد الشوارع','واجهات الشوارع','عرض الشارع الرئيسي','عرض الشارع الرئيسي','رقم الرخصة','مصدر الرخصة','تاريخ الرخصة',
                //     'تاريخ الرخصة','قيم القياس']);
                // }])
                // ->
                where('id', $not->estate_id)->first();

            return $estate->revised_by_enter ? view('frontend.steps.entre_second_page', compact('estate')) : redirect()->route('estates.edit', ['subdomain' => $subdomain, 'estate' => $estate->id]);
        }

        if (auth()->user()->membership_level == 'qima_approver' || auth()->user()->hasRole('value_approver')) {
            $not = DashNotification::find($not_id);
            $estate = Estate::where('id', $not->estate_id)->first();
            return view('frontend.steps.qima_approver_page', compact('estate'));
        }

        if (auth()->user()->membership_level == 'coordinator' || auth()->user()->hasRole('coordinator')) {

            $not = DashNotification::find($not_id);
            $estate = Estate::where('id', $not->estate_id)->first();
            $previewers = User::where('membership_level', 'previewer')->orWhereHas("roles", function ($q) {
                $q->where("name", "previewer");
            })->active()->get();
            $reviewers = User::where('membership_level', 'reviewer')->orWhereHas("roles", function ($q) {
                $q->where("name", "reviewer");
            })->active()->get();
            $approvers = User::where('membership_level', 'approver')->orWhereHas("roles", function ($q) {
                $q->where("name", "approver");
            })->active()->get();
            $value_approvers = User::where('membership_level', 'qima_approver')->orWhereHas("roles", function ($q) {
                $q->where("name", "value_approver");
            })->active()->get();
            $raters = User::where('membership_level', 'rater')->orWhereHas("roles", function ($q) {
                $q->where("name", "rater");
            })->active()->get();
            $cities = City::all();
            $zones = Zone::all();
            $countries = Country::all();
            return view('frontend.steps.coordinator_page', compact('estate', 'previewers', 'reviewers', 'approvers','value_approvers', 'raters','cities','zones','countries'));
        }

        if (auth()->user()->membership_level == 'previewer' || auth()->user()->hasRole('previewer')) {
            $not = DashNotification::find($not_id);
            if (!$not) {
                return redirect()->route('home', $subdomain);
            }
            $estate = Estate::where('id', $not->estate_id)->first();
            return view('frontend.steps.previewer_page', compact('estate'));
        }

        if (auth()->user()->membership_level == 'rater' || auth()->user()->hasRole('rater')) {
            $not = DashNotification::find($not_id);
            $estate = Estate::where('id', $not->estate_id)->first();
            return view('frontend.steps.rater_page', compact('estate'));
        }

        if (auth()->user()->membership_level == 'reviewer' || auth()->user()->hasRole('reviewer')) {
            $not = DashNotification::find($not_id);
            $estate = Estate::where('id', $not->estate_id)->first();
            return view('frontend.steps.reviewer_page', compact('estate'));
        }

        if (auth()->user()->membership_level == 'approver' || auth()->user()->hasRole('approver')) {
            $not = DashNotification::find($not_id);
            $estate = Estate::where('id', $not->estate_id)->first();
            return view('frontend.steps.approver_page', compact('estate'));
        }
    }

    public function completeEntry($subdomain, $estate_id)
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
        return redirect()->route('not_open', ['not_id' => $not->id, 'subdomain' => $subdomain]);
    }
    public function level_refuse($subdomain, $estate_id, $type)
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
        return redirect()->route('home', $subdomain)->with('done', 'تم الارسال الى المعاين لابلاغة بالرفض');
    }

    public function level_inputs($subdomain, $estate_id, Request $request)
    {
        try {

            DB::beginTransaction();
            $estate = Estate::where('id', $estate_id)->first();
            if (!$estate) {
                DB::rollBack();
                return redirect()->route('home', $subdomain)->with('done', 'عقار غير موجود');
            }

            if (auth()->user()->membership_level == 'rater_manager' || auth()->user()->hasRole('rater_manager')) {
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
                    return redirect()->route('home', $subdomain)->with('done', 'تم الالغاء والحفظ كمسودة');
                }
                if ($request->return) {

                    $estate = Estate::where('id', $estate_id)->first();
                    //delete from draft if exists
                    $estate->drafted_by = null;
                    $estate->draft_note = $request->draft_note;
                    $estate->save();

                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();

                    $users = User::whereId($estate->user_id)->pluck('id');
                    if ($estate->entered_by) $users = User::where('id', $estate->entered_by)->pluck('id');

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
                    return redirect()->route('home', $subdomain)->with('done', 'تم رفض الطلب وإعادته للادخال');
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

                    for ($i = 1; $i <= $request->qty; $i++) {
                        $input_works = new EstateInput();
                        $input_works->key = 'موعد الدفعة  '.$i;
                        $input_works->value = $request->payment_partitions[$i-1];
                        $input_works->estate_id = $estate_id;
                        $input_works->user_id = auth()->user()->id;
                        $input_works->save();
                    }

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

                    return redirect()->route('home', $subdomain)->with('done', 'تم الارسال الى مدير المنشأة بنجاح');
                } else {
                    $users = User::where('membership_level', 'entre')->pluck('id');
                    $this->send_notification($users, '' . $estate->id . '', '#4169E1', 'fa fa-eye', '  تم الارسال لاكمال المدخلات');
                    DB::commit();

                    return redirect()->route('home', $subdomain)->with('done', 'تم  الارسال الى مرحلة الادخال ');
                }
            }
            if (auth()->user()->membership_level == 'manager' || auth()->user()->hasRole('manager')) {

                $estate = Estate::where('id', $estate_id)->first();

                if ($request->cancel) {

                    $estate->drafted_by = auth()->id();
                    $estate->draft_note = $request->draft_note;
                    $estate->save();

                    OrderProcessingNote::create([
                        'path_type' => 'public',
                        'step_number' => 5,
                        'estate_id' => $estate_id,
                        'user_id' => auth()->id(),
                        'reason' => 'reject',
                        'note' => $request->draft_note ?? '',
                    ]);

                    $inputs = EstateInput::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->get();
                    if ($inputs->count() > 0) {
                        foreach ($inputs as $inp) {
                            $inp->delete();
                        }
                    }
                    //TODO:: add show/hide for notitication
                    // DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    DB::commit();
                    return redirect()->route('home', $subdomain)->with('done', 'تم الالغاء والحفظ كمسودة');
                }
                if ($request->return) {
                    // $inputs = EstateInput::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->get();
                    // if ($inputs->count() > 0) {
                    //     foreach ($inputs as $inp) {
                    //         $inp->delete();
                    //     }
                    // }
                    $estate->drafted_by = null;
                    $estate->draft_note = $request->draft_note;
                    $estate->save();

                    OrderProcessingNote::create([
                        'path_type' => 'public',
                        'step_number' => $request->return == 'reviewer' ? 14 : 5,
                        'estate_id' => $estate_id,
                        'user_id' => auth()->id(),
                        'reason' => 'return',
                        'note' => $request->draft_note ?? '',
                    ]);

                    $return_to = $request->return == 'reviewer' ? 'المراجع' : 'مدير التقييم';
                    if ($request->return == 'rater_manager') {
                        $users = User::where('membership_level', 'rater_manager')->orWhereHas("roles", function ($q) {
                            $q->where("name", "rater_manager");
                        })
                            ->pluck('id');
                    } else {
                        $users = User::where('id', $estate->reviewer_id)
                            ->pluck('id');
                    }

                    $this->send_notification($users, '' . $estate->id . '', '#8B0000', 'fa fa-user', 'تم ارجاع الطلب من قبل مدير المنشاة  ' . $return_to);

                    $input = new EstateInput();
                    $input->key = 'موافقة مدير المنشأة';
                    $input->value = 'رفض';
                    $input->estate_id = $estate_id;
                    $input->user_id = auth()->user()->id;
                    $input->save();

                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    DB::commit();

                    return redirect()->route('home', $subdomain)->with('done', 'تم الارجاع الى ' . $return_to);
                }
                //ارسال الى الادخال
                if ($request->approve) {
                    // $inputs = EstateInput::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->get();
                    // if ($inputs->count() > 0) {
                    //     foreach ($inputs as $inp) {
                    //         $inp->delete();
                    //     }
                    // }
                    $estate->drafted_by = null;
                    $estate->draft_note = $request->draft_note;
                    $estate->save();

                    $input = new EstateInput();
                    $input->key = 'موافقة مدير المنشأة';
                    $input->value = 'موافقة';
                    $input->estate_id = $estate_id;
                    $input->user_id = auth()->user()->id;
                    $input->save();

                    $users = User::where('membership_level', 'entre')->orWhereHas("roles", function ($q) {
                        $q->where("name", "enter");
                    })
                        ->pluck('id');
                    $this->send_notification($users, '' . $estate->id . '', '#4169E1', 'fa fa-eye', '  تم اعتماد الطلب من طرف مدير المشأة لاكمال البيانات التفصيلية');

                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    DB::commit();

                    return redirect()->route('home', $subdomain)->with('done', 'تم اعتماد الطلب وارساله الى الادخال لإكمال البيانات التفصيلية');
                }
                //ارسال الى الاعتماد المرحلة 14
                if ($request->send_to_approver) {



                    $input = new EstateInput();
                    $input->key = 'موافقة مدير المنشأة';
                    $input->value = 'موافقة';
                    $input->estate_id = $estate_id;
                    $input->user_id = auth()->user()->id;
                    $input->save();

                    $users = User::where('id', $estate->approver_id)
                        ->pluck('id');
                    $this->send_notification($users, '' . $estate->id . '', '#2E8B57', 'fa fa-user', 'تم ارسال طلب للاعتماد من قبل مدير المنشأة ');


                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    DB::commit();

                    return redirect()->route('home', $subdomain)->with('done', 'تم ارسال الطلب للاعتماد');
                }
                //17 send report and finish order
                if ($estate->qema) {
                    if ($request->send_to_client) {

                        //update estate status to 1:means report is sended to client
                        $estate->recieved_by_client = 1;
                        $estate->save();

                        $users = User::where('id', $estate->user_id)
                            ->pluck('id');

                        $this->send_notification($users, '' . $estate->id . '', '#2E8B57', 'fa fa-user', 'تم انتهاءالتقرير ،يرجى تأكيد الاستلام ');


                        DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                        DB::commit();

                        return redirect()->route('home', $subdomain)->with('done', 'تم ارسال الطلب للعميل لتأكيد الاستلام');
                    }
                    if ($request->return) {

                        $estate->drafted_by = null;
                        $estate->draft_note = $request->draft_note;
                        $estate->save();

                        OrderProcessingNote::create([
                            'path_type' => 'public',
                            'step_number' => 17,
                            'estate_id' => $estate_id,
                            'user_id' => auth()->id(),
                            'reason' => 'return',
                            'note' => $request->draft_note ?? '',
                        ]);

                        $users = User::where('membership_level', 'qima_approver')->orWhereHas("roles", function ($q) {
                            $q->where("name", "value_approver");
                        })
                            ->pluck('id');

                        $this->send_notification($users, '' . $estate->id . '', '#8B0000', 'fa fa-user', 'تم ارجاع الطلب من  طرف مديرالمنشأة  ' . $return_to);

                        $input = new EstateInput();
                        $input->key = 'موافقة مدير المنشأة';
                        $input->value = 'رفض';
                        $input->estate_id = $estate_id;
                        $input->user_id = auth()->user()->id;
                        $input->save();

                        DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                        DB::commit();

                        return redirect()->route('home', $subdomain)->with('done', 'تم الارجاع الى معتمد قيمة');
                    }
                    if ($request->cancel) {

                        $estate->drafted_by = auth()->id();
                        $estate->draft_note = $request->draft_note;
                        $estate->save();

                        OrderProcessingNote::create([
                            'path_type' => 'public',
                            'step_number' => 17,
                            'estate_id' => $estate_id,
                            'user_id' => auth()->id(),
                            'reason' => 'reject',
                            'note' => $request->draft_note ?? '',
                        ]);

                        //TODO:: add show/hide for notitication
                        // DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                        DB::commit();
                        return redirect()->route('home', $subdomain)->with('done', 'تم الالغاء والحفظ كمسودة');
                    }
                    if ($request->end_report) {

                        $estate->drafted_by = null;
                        $estate->draft_note = null;
                        $estate->recieved_by_client = 2;
                        $estate->archive = 1;
                        $estate->save();

                        DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                        DB::commit();

                        return redirect()->route('home', $subdomain)->with('done', 'تم تأكيد الاستلام وإنهاءالطلب');
                    }
                }
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

                // $users = User::where('membership_level', 'entre')
                // ->orWhereHas("roles", function($q){ $q->where("name", "enter"); })
                // ->pluck('id');
                $users = User::where('id', $estate->user_id)->pluck('id');
                $this->send_notification($users, '' . $estate->id . '', '#2E8B57', 'fa fa-user', 'تم إنجاز العقد على اللطلب #' . $estate->id);
                // $this->send_notification($users, '' . $estate->id . '', '#2E8B57', 'fa fa-user', 'اكمال عملية ادخال البيانات');

                $input = new EstateInput();
                $input->key = 'موافقة مدير المنشأة';
                $input->value = 'موافقة';
                $input->estate_id = $estate_id;
                $input->user_id = auth()->user()->id;
                $input->save();

                DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                DB::commit();

                return redirect()->route('home', $subdomain)->with('done', 'تم إرسال العقد إلى العميل');
                // return redirect()->route('home',$subdomain)->with('done', 'تم الارسال الى مرحلة ادخال باقي المعلومات');


            }
            if (auth()->user()->membership_level == 'client') {

                $estate = Estate::where('id', $estate_id)->first();
                $not = DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->first();


                if ($request->cancel && $not?->current_step == 6) {
                    //register as drafted
                    $estate->drafted_by = auth()->id();
                    $estate->draft_note = $request->note;
                    $estate->save();
                    OrderProcessingNote::create([
                        'path_type' => 'public',
                        'step_number' => 6,
                        'estate_id' => $estate_id,
                        'user_id' => auth()->id(),
                        'reason' => 'reject',
                        'note' => $request->draft_note ?? '',
                    ]);
                    $inputs = EstateInput::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->get();
                    if ($inputs->count() > 0) {
                        foreach ($inputs as $inp) {
                            $inp->delete();
                        }
                    }
                    $users = User::where('membership_level', 'manager')
                        ->orWhereHas("roles", function ($q) {
                            $q->where("name", "manager");
                        })
                        ->pluck('id');
                    $this->send_notification($users, '' . $estate->id . '', '#8B0000', 'fa fa-user', 'تم الرفض من العميل والارجاع الى مدير المنشأة');

                    $input = new EstateInput();
                    $input->key = 'موافقة  العميل';
                    $input->value = 'رفض';
                    $input->estate_id = $estate_id;
                    $input->user_id = auth()->user()->id;
                    $input->save();

                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();

                    return redirect()->route('client_home',$subdomain)->with('done', 'تم الارجاع الى مدير المنشأة');
                }
                if ($request->return) {
                    OrderProcessingNote::create([
                        'path_type' => 'public',
                        'step_number' => 13,
                        'estate_id' => $estate_id,
                        'user_id' => auth()->id(),
                        'reason' => 'return',
                        'note' => $request->reject_note ?? '',
                    ]);

                    $users = User::where('id', $estate->reviewer_id)
                        ->pluck('id');
                    $this->send_notification($users, '' . $estate->id . '', '#8B0000', 'fa fa-user', 'تم إعادة الطلب من قبل العميل ');

                    $input = new EstateInput();
                    $input->key = 'إعادة الطلب من قبل العميل';
                    $input->value = 'رفض';
                    $input->estate_id = $estate_id;
                    $input->user_id = auth()->user()->id;
                    $input->save();

                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    DB::commit();
                    return redirect()->route('home', $subdomain)->with('done', 'تم إعادة الطلب إلى المراجع');
                }
                if ($estate->recieved_by_client == 1) {

                    $estate->recieved_by_client = 2;
                    $estate->save();

                    $users = User::where('membership_level', 'manager')
                        ->orWhereHas("roles", function ($q) {
                            $q->where("name", "manager");
                        })
                        ->pluck('id');

                    $this->send_notification($users, '' . $estate->id . '', '#2E8B57', 'fa fa-user', 'قام العميل بتأكيد استلام التقرير');

                    $input = new EstateInput();
                    $input->key = 'موافقة العميل';
                    $input->value = 'موافقة';
                    $input->estate_id = $estate_id;
                    $input->user_id = auth()->user()->id;
                    $input->save();

                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    DB::commit();
                    return redirect()->route('client_home',$subdomain)->with('done', 'تم تأكيد استلام التقرير');
                }
                //if accept
                // $inputs = EstateInput::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->get();
                // if ($inputs->count() > 0) {
                //     foreach ($inputs as $inp) {
                //         $inp->delete();
                //     }
                // }
                OrderProcessingNote::create([
                    'path_type' => 'public',
                    'step_number' => $estate->process_start_date ? 13 : 6,
                    'estate_id' => $estate_id,
                    'user_id' => auth()->id(),
                    'reason' => 'accept',
                    'note' => $request->note ?? '',
                ]);
                $users = User::where('membership_level', 'manager')
                    ->orWhereHas("roles", function ($q) {
                        $q->where("name", "manager");
                    })
                    ->pluck('id');

                $this->send_notification($users, '' . $estate->id . '', '#2E8B57', 'fa fa-user', $estate->process_start_date ? 'موافقة العميل بعد المراجعة' : 'موافقة العميل واكمال عملية ادخال البيانات');

                $input = new EstateInput();
                $input->key = 'موافقة العميل';
                $input->value = 'موافقة';
                $input->estate_id = $estate_id;
                $input->user_id = auth()->user()->id;
                $input->save();

                DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                DB::commit();
                return redirect()->route('client_home',$subdomain)->with('done', 'تم الموافقة والارسال الى مدير المنشأة');
            }

            if (auth()->user()->membership_level == 'entre' || auth()->user()->hasRole('enter')) {
                $estate = Estate::where('id', $estate_id)->first();
                if ($request->return) {
                    $inputs = EstateInput::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->get();
                    if ($inputs->count() > 0) {
                        foreach ($inputs as $inp) {
                            $inp->delete();
                        }
                    }
                    OrderProcessingNote::create([
                        'path_type' => 'public',
                        'step_number' => 8,
                        'estate_id' => $estate_id,
                        'user_id' => auth()->id(),
                        'reason' => 'reject',
                        'note' => $request->reject_note ?? '',
                    ]);
                    //delete manager acceptation
                    EstateInput::whereEstateId($estate_id)->where('key', 'like', "%موافقة مدير المنشأة%")->first()->delete();

                    $users = User::where('membership_level', 'manager')
                        ->orWhereHas("roles", function ($q) {
                            $q->where("name", "manager");
                        })
                        ->pluck('id');
                    $this->send_notification($users, '' . $estate->id . '', '#8B0000', 'fa fa-user', 'تم رفض الطلب من قبل الادخال ');

                    $input = new EstateInput();
                    $input->key = 'رد بخصوص اكمال تفاصيل الطلب من الادخال';
                    $input->value = 'رفض';
                    $input->estate_id = $estate_id;
                    $input->user_id = auth()->user()->id;
                    $input->save();

                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    DB::commit();
                    return redirect()->route('home', $subdomain)->with('done', 'تم إرسال الطلب الى مدير المنشأة');
                }
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
                return redirect()->route('home', $subdomain)->with('done', 'تم الارسال الى المنسق لاكمال باقي المراحل');
            }

            if (auth()->user()->membership_level == 'previewer' || auth()->user()->hasRole('previewer')) {
                $estate = Estate::where('id', $estate_id)->first();
                $price_list = [];
                $price_list = $request->infos;

                $estate->previewer = 2;
                $estate->save();

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
                return redirect()->route('home', $subdomain)->with('done', 'تم الارسال الى المقيم لاكمال باقي المراحل');
            }

            if (auth()->user()->membership_level == 'rater' || auth()->user()->hasRole('rater')) {

                if ($request->return) {

                    OrderProcessingNote::create([
                        'path_type' => 'public',
                        'step_number' => 11,
                        'estate_id' => $estate_id,
                        'user_id' => auth()->id(),
                        'reason' => 'reject',
                        'note' => $request->reject_note ?? '',
                    ]);

                    $users = User::where('membership_level', $request->return)
                        ->orWhereHas("roles", function ($q) use ($request) {
                            $q->where("name", $request->return);
                        })
                        ->pluck('id');
                    $this->send_notification($users, '' . $estate->id . '', '#8B0000', 'fa fa-user', 'تم إعادة الطلب من قبل المقيم ');

                    $input = new EstateInput();
                    $input->key = 'إعادة الطلب من قبل المقيم';
                    $input->value = 'رفض';
                    $input->estate_id = $estate_id;
                    $input->user_id = auth()->user()->id;
                    $input->save();

                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    DB::commit();
                    $type = $request->type == "coordinator" ? ' المنسق' : 'المعاين';
                    return redirect()->route('home', $subdomain)->with('done', 'تم إعادة الطلب إلى ' . $type);
                }

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
                // if ($request->assessment == 'investment') {

                //     return redirect()->route('investments.create');
                // }
                if ($request->assessment == 'land') {
                    return redirect()->route('land.create');
                }
                // if ($request->assessment == 'parking') {
                //     return redirect()->route('parking.create');
                // }
                // if ($request->assessment == 'petrol') {
                //     return redirect()->route('petrol_station.create');
                // }
                // if ($request->assessment == 'estate') {
                //     return redirect()->route('build.create');
                // }
                // if ($request->assessment == 'farm') {
                //     return redirect()->route('farm.create');
                // }
                return redirect()->route('home', $subdomain)->with('done', 'تم الارسال الى المراجع لاكمال باقي المراحل');
            }

            if (auth()->user()->membership_level == 'reviewer' || auth()->user()->hasRole('reviewer')) {
                $estate = Estate::where('id', $estate_id)->first();
                if ($request->accept == 'manager') {
                    $users = User::where('membership_level', 'manager')
                        ->orWhereHas("roles", function ($q) {
                            $q->where("name", 'manager');
                        })
                        ->pluck('id');
                    //add an id to collection
                    $users = $users->prepend($estate->user_id);
                    //            $users = User::where('id', $estate->user_id)->pluck('id');
                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    $this->send_notification($users, '' . $estate->id . '', '#40E0D0', 'fa fa-user', 'أرسل المراجع الطلب بعد المراجعة');
                    DB::commit();
                    return redirect()->route('home', $subdomain)->with('done', ' تم ارسال الطلب الى مدير المنشأة ومسودة للعميل');
                } elseif ($request->accept == 'rater') { //reject
                    $estate->rater_reason = $request->reject_note ?? '';
                    $estate->save();
                    //create a note
                    OrderProcessingNote::create([
                        'path_type' => 'public',
                        'step_number' => 12,
                        'estate_id' => $estate_id,
                        'user_id' => auth()->id(),
                        'reason' => 'reject',
                        'note' => $request->reject_note ?? '',
                    ]);
                    $users = User::where('membership_level', 'rater')
                        ->orWhereHas("roles", function ($q) {
                            $q->where("name", 'rater');
                        })
                        ->pluck('id');
                    //            $users = User::where('id', $estate->user_id)->pluck('id');
                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    $this->send_notification($users, '' . $estate->id . '', '#40E0D0', 'fa fa-user', 'عملية رفض على ما تم تقييمة');
                    DB::commit();
                    return redirect()->route('home', $subdomain)->with('done', 'تم الارسال الى المقيم مرة اخرى');
                } elseif ($request->accept == 'previewer') { //reject
                    $estate->previewer_reason = $request->reject_note ?? '';
                    $estate->save();
                    //create a note
                    OrderProcessingNote::create([
                        'path_type' => 'public',
                        'step_number' => 12,
                        'estate_id' => $estate_id,
                        'user_id' => auth()->id(),
                        'reason' => 'reject',
                        'note' => $request->reject_note ?? '',
                    ]);
                    $users = User::where('membership_level', 'previewer')
                        ->orWhereHas("roles", function ($q) {
                            $q->where("name", 'previewer');
                        })
                        ->pluck('id');
                    //            $users = User::where('id', $estate->user_id)->pluck('id');
                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    $this->send_notification($users, '' . $estate->id . '', '#40E0D0', 'fa fa-user', 'عملية رفض   وتم الارسال الى المعاين ');
                    DB::commit();
                    return redirect()->route('home', $subdomain)->with('done', 'تم الارسال الى المعاين مرة اخرى');
                }
            }

            if (auth()->user()->membership_level == 'coordinator' || auth()->user()->hasRole('coordinator')) {
                if ($request->return) {

                    OrderProcessingNote::create([
                        'path_type' => 'public',
                        'step_number' => 9,
                        'estate_id' => $estate_id,
                        'user_id' => auth()->id(),
                        'reason' => 'reject',
                        'note' => $request->reject_note ?? '',
                    ]);

                    $users = User::where('membership_level', 'entre')
                        ->orWhereHas("roles", function ($q) {
                            $q->where("name", "enter");
                        })
                        ->pluck('id');
                    $this->send_notification($users, '' . $estate->id . '', '#8B0000', 'fa fa-user', 'تم إعادة الطلب من قبل المنسق ');

                    $input = new EstateInput();
                    $input->key = 'إعادة الطلب من قبل المنسق';
                    $input->value = 'رفض';
                    $input->estate_id = $estate_id;
                    $input->user_id = auth()->user()->id;
                    $input->save();

                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    DB::commit();
                    return redirect()->route('home', $subdomain)->with('done', 'تم إعادة الطلب إلى الادخال');
                }
                $this->validate($request, [
                    'rater_id' => 'required|numeric',
                    'reviewer_id' => 'required|numeric',
                    'approver_id' => 'required|numeric',
                    'value_approver_id' => 'required|numeric',
                    'previewer_id' => 'required|numeric',
                    'process_start_date'     => 'required|date',
                    'process_end_date'     => 'required|date',
                ]);
                $estate = Estate::where('id', $estate_id)->first();

                $estate->reviewer_id = $request->reviewer_id;
                $estate->previewer_id = $request->previewer_id;
                $estate->approver_id = $request->approver_id;
                $estate->value_approver_id = $request->value_approver_id;
                $estate->rater_id = $request->rater_id;

                $estate->city_id = $request->city_id ?: $estate->city_id;
                $estate->address = $request->address ?: $estate->address;

                $estate->process_start_date = $request->process_start_date;
                $estate->process_end_date = $request->process_end_date;


                $estate->reviewer = $estate->reviewer == 2 ? 0 : $estate->reviewer;
                $estate->approver = $estate->approver == 2 ? 0 : $estate->approver;
                $estate->value_approver = $estate->value_approver == 2 ? 0 : $estate->value_approver;
                $estate->previewer = $estate->previewer == 2 ? 0 : $estate->previewer;
                $estate->rater = $estate->rater == 2 ? 0 : $estate->rater;
                $estate->save();
                DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();

                $users = User::where('id', $request->previewer_id)->pluck('id');
                $this->send_notification($users, '' . $estate->id . '', '#D18700', 'fa fa-eye', 'يرجى المراجعة لاكمال باقي المراحل');
                DB::commit();
                return redirect()->route('home', $subdomain)->with('done', 'تم الارسال الى المعاين لاكمال باقي المراحل');
            }
            if (auth()->user()->membership_level == 'approver' || auth()->user()->hasRole('approver')) {
                $estate = Estate::where('id', $estate_id)->first();

                if ($request->return) {

                    $estate->drafted_by = null;
                    $estate->draft_note = $request->draft_note;
                    $estate->save();

                    OrderProcessingNote::create([
                        'path_type' => 'public',
                        'step_number' => $request->return == 'manager' ? 15 : 5,
                        'estate_id' => $estate_id,
                        'user_id' => auth()->id(),
                        'reason' => 'return',
                        'note' => $request->draft_note ?? '',
                    ]);

                    $return_to = $request->return == 'manager' ? 'مدير المنشأة' : 'المنسق';
                    if ($request->return == 'manager') {
                        $users = User::where('membership_level', 'manager')->orWhereHas("roles", function ($q) {
                            $q->where("name", "manager");
                        })
                            ->pluck('id');
                    } else {
                        User::where('membership_level', 'coordinator')->orWhereHas("roles", function ($q) {
                            $q->where("name", "coordinator");
                        })
                            ->pluck('id');
                    }

                    $this->send_notification($users, '' . $estate->id . '', '#8B0000', 'fa fa-user', 'تم ارجاع الطلب من قبل مدير المعتمد  ' . $return_to);

                    $input = new EstateInput();
                    $input->key = 'موافقة المعتمد';
                    $input->value = 'رفض';
                    $input->estate_id = $estate_id;
                    $input->user_id = auth()->user()->id;
                    $input->save();

                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    DB::commit();

                    return redirect()->route('home', $subdomain)->with('done', 'تم الارجاع الى ' . $return_to);
                }
                //ارسال الى الادخال
                if ($request->approve) {
                    // $inputs = EstateInput::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->get();
                    // if ($inputs->count() > 0) {
                    //     foreach ($inputs as $inp) {
                    //         $inp->delete();
                    //     }
                    // }
                    $estate->drafted_by = null;
                    $estate->draft_note = $request->draft_note;
                    $estate->save();

                    $input = new EstateInput();
                    $input->key = 'موافقة مدير المنشأة';
                    $input->value = 'موافقة';
                    $input->estate_id = $estate_id;
                    $input->user_id = auth()->user()->id;
                    $input->save();

                    $users = User::where('membership_level', 'entre')->orWhereHas("roles", function ($q) {
                        $q->where("name", "enter");
                    })
                        ->pluck('id');
                    $this->send_notification($users, '' . $estate->id . '', '#4169E1', 'fa fa-eye', '  تم اعتماد الطلب من طرف مدير المشأة لاكمال البيانات التفصيلية');

                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    DB::commit();

                    return redirect()->route('home', $subdomain)->with('done', 'تم اعتماد الطلب وارساله الى الادخال لإكمال البيانات التفصيلية');
                }
                //ارسال الى الاعتماد المرحلة 14
                if ($request->send_to_value_approver) {

                    $estate->approver = 2;
                    $estate->save();

                    $input = new EstateInput();
                    $input->key = 'موافقة المعتمد';
                    $input->value = 'موافقة';
                    $input->estate_id = $estate_id;
                    $input->user_id = auth()->user()->id;
                    $input->save();

                    $users = User::where('membership_level', 'qima_approver')->orWhereHas("roles", function ($q) {
                        $q->where("name", "value_approver");
                    })->pluck('id');
                    $this->send_notification($users, '' . $estate->id . '', '#2E8B57', 'fa fa-user', 'تم ارسال الطلب من طرف المعتمد ');


                    // DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    DB::commit();

                    return redirect()->route('home', $subdomain)->with('done', 'تم ارسال الطلب لاعتماد قيمة');
                }
                // if ($request->accept == 1) {
                //     $estate->archive = 1;
                //     // $estate->qema = $request->qema_code;
                //     $estate->save();
                //     // $input = new EstateInput();
                //     // $input->key = 'رقم التسجيل في قيمة';
                //     // $input->value = $request->qema_code ?: '1';
                //     // $input->estate_id = $estate_id;
                //     // $input->user_id = auth()->user()->id;
                //     // $input->save();

                //     try {
                //         DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                //         $users = User::where('membership_level', 'qima_approver')->pluck('id');
                //         //            $users = User::where('id', $estate->user_id)->pluck('id');
                //         $this->send_notification($users, '' . $estate->id . '', '#000', 'fa fa-user', 'تم الارسال الى معتمد قيمة');
                //     } catch (\Exception $e) {
                //     }
                //     DB::commit();

                //     return redirect()->route('home',$subdomain)->with('done', 'تمت الموافقة والارسال الى مراجع قيمة ');
                // }
                // if ($request->accept == 2) {
                //     // $inputs = EstateInput::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->get();
                //     // if ($inputs->count() > 0) {
                //     //     foreach ($inputs as $inp) {
                //     //         $inp->delete();
                //     //     }
                //     // }
                //     $users = User::where('membership_level', 'rater_manager')->pluck('id');
                //     $this->send_notification($users, '' . $estate->id . '', '#8B0000', 'fa fa-user', 'تم الارجاع الى مدخل البيانات');

                //     $input = new EstateInput();
                //     $input->key = 'موافقة الاعتماد ';
                //     $input->value = 'رفض';
                //     $input->estate_id = $estate_id;
                //     $input->user_id = auth()->user()->id;
                //     $input->save();

                //     DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                //     DB::commit();

                //     return redirect()->route('home',$subdomain)->with('done', 'تم الارجاع الى مدخل البيانات');
                // }
            }
            if (auth()->user()->membership_level == 'qima_approver' || auth()->user()->hasRole('value_approver')) {
                $estate = Estate::where('id', $estate_id)->first();

                //if return
                if ($request->return) {

                    $estate->drafted_by = null;
                    $estate->draft_note = $request->draft_note;
                    $estate->save();

                    OrderProcessingNote::create([
                        'path_type' => 'public',
                        'step_number' => 16,
                        'estate_id' => $estate_id,
                        'user_id' => auth()->id(),
                        'reason' => 'return',
                        'note' => $request->draft_note ?? '',
                    ]);

                    $return_to = $request->return == 'approver' ? 'المعتمد' : 'المنسق';
                    if ($request->return == 'approver') {
                        $users = User::where('membership_level', 'approver')->orWhereHas("roles", function ($q) {
                            $q->where("name", "approver");
                        })
                            ->pluck('id');
                    } else {
                        User::where('membership_level', 'coordinator')->orWhereHas("roles", function ($q) {
                            $q->where("name", "coordinator");
                        })
                            ->pluck('id');
                    }

                    $this->send_notification($users, '' . $estate->id . '', '#8B0000', 'fa fa-user', 'تم ارجاع الطلب من قبل مدير المعتمد  ' . $return_to);

                    $input = new EstateInput();
                    $input->key = 'موافقة المعتمد';
                    $input->value = 'رفض';
                    $input->estate_id = $estate_id;
                    $input->user_id = auth()->user()->id;
                    $input->save();

                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    DB::commit();

                    return redirect()->route('home', $subdomain)->with('done', 'تم الارجاع الى ' . $return_to);
                }
                if ($request->cancel) {

                    $estate = Estate::where('id', $estate_id)->first();
                    $estate->drafted_by = auth()->id();
                    $estate->draft_note = $request->draft_note;
                    $estate->save();

                    // $inputs = EstateInput::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->get();
                    // if ($inputs->count() > 0) {
                    //     foreach ($inputs as $inp) {
                    //         $inp->delete();
                    //     }
                    // }
                    //TODO:: add show/hide for notitication
                    // DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                    DB::commit();
                    return redirect()->route('home', $subdomain)->with('done', 'تم الالغاء والحفظ كمسودة');
                }

                $estate->qema = $request->qema_code;
                $estate->save();

                $input = new EstateInput();
                $input->key = 'رقم التسجيل في قيمة';
                $input->value = $request->qema_code ?: '1';
                $input->estate_id = $estate_id;
                $input->user_id = auth()->user()->id;
                $input->save();

                if ($request->file('files')) {
                    $this->saveimages($request->file('files'), 'pictures/estates', $estate->id, Estate::class, 'file');
                }

                $users = User::where('membership_level', 'manager')->orWhereHas("roles", function ($q) {
                    $q->where("name", "manager");
                })
                    ->pluck('id');

                $this->send_notification($users, '' . $estate->id . '', '#2E8B57', 'fa fa-user', 'تم ارسال الطلب من طرف معتمد قيمة ');

                try {
                    DashNotification::where([['estate_id', $estate_id], ['user_id', auth()->user()->id]])->delete();
                } catch (\Exception $e) {
                }
                DB::commit();

                return redirect()->route('home', $subdomain)->with('done', 'تم ارسال الطلب الى مدير المنشأة ');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // return $request->infos;
            dd($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit_archive($subdomain, $estate_id)
    {
        try {
            $estate = Estate::where('id', $estate_id)->first();
            $inputs = \DB::table('estate_inputs')->where('estate_id', $estate_id)->get();
            return view('frontend.estates.edit_archive', compact('estate', 'inputs'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', ' يوجد مشكلة يرجى التواصل مع صاحب الخدمة');
        }
    }

    public function edit_archive_post($subdomain, $estate_id, Request $request)
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
            return redirect()->route('home', $subdomain)->with('done', 'تمت التعديل  بنجاح  ');
        } catch (\Exception $e) {
            DB::rollBack();
            // return $request->infos;
            return redirect()->back()->with('error', ' من فضلك قم بملئ جميع الحقول');
        }
    }
    public function reopenEstateOrder($subdomain, $estate_id)
    {
        try {

            $estate = Estate::where('id', $estate_id)->first();
            $estate->drafted_by = null;
            $estate->save();
            return redirect()->route('home', $subdomain)->with('done', 'تم إعادة فتح الطلب  بنجاح  ');
        } catch (\Exception $e) {
            DB::rollBack();
            // return $request->infos;
            return redirect()->back()->with('error', $e->getMessages());
        }
    }
}
