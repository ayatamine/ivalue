<?php

namespace App\Http\Controllers\User\Incomes;

use DB;
use App\Models\Estate;
use App\Incomes\Investment;
use App\Models\EstateInput;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class InvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $types = Investment::where('type', 'main')->orderBy('id', 'desc')->pluck('estate_id');
            $estates = Estate::whereIn('id',$types)->get();
            return view('frontend.incomes.investments.index', compact('types','estates'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $types = Investment::where('type', 'main')->orderBy('id', 'desc')->pluck('estate_id');
            $estates = Estate::whereNotIn('id',$types)->get();
            return view('frontend.incomes.investments.creat', compact('estates'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store($subdomain,Request $request)
    {

        DB::beginTransaction();

        try {

             $estate = Estate::where('id', $request->estate_id)->first();
             $estate_id = $estate->id;

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


            for ($x = 0; $x <= 24; $x++) {
                if ($x == 0) {
                    $key = 'main';
                    $name = 'المساحه التأجيرية';
                    $type = 'main';
                    $value = $request['value'][0];
                }
                if ($x == 1) {
                    $key = 'sub_main';
                    $name = 'اجمالي الايجار السنوي';
                    $type = 'sub_main';
                    $value = $request['value'][1];
                }
                if ($x == 3) {
                    $key = 'old_1';
                    $name = 'ايجار للمتر المربع';
                    $type = 'old';
                    $value = $request['value'][0] / $request['value'][1];
                }
                if ($x == 4) {
                    $key = 'old_2';
                    $name = 'نسبه المصاريف التشغيلية';
                    $type = 'old';
                    $value = $request['value'][2];
                }
                if ($x == 5) {
                    $key = 'old_3';
                    $name = 'اجمالي المصاريف التشغيلية ';
                    $type = 'old';
                    $value = $request['value'][1] * $request['value'][2];
                }
//
                if ($x == 6) {
                    $key = 'old_6';
                    $name = 'تاريخ انتهاء العقد';
                    $type = 'old';
                    $value = $request['value'][3];
                }
                if ($x == 7) {
                    $key = 'old_8';
                    $name = 'معدل العائد للابدية';
                    $type = 'old';
                    $value = $request['value'][4];
                }
                if ($x == 8) {
                    $key = 'old_9';
                    $name = 'عامل شراء السنوات لفتره محدوده';
                    $type = 'old';
                    $value = $request['value'][5];
                }
                if ($x == 9) {
                    $key = 'new_5';
                    $name = 'معدل العائد للابدية';
                    $type = 'new';
                    $value = $request['value'][6];
                }
                if ($x == 10) {
                    $key = 'new_8';
                    $name = 'نسبة المصاريف التشغيلية';
                    $type = 'new';
                    $value = $request['value'][8];
                }
                if ($x == 11) {
                    $key = 'new_1';
                    $name = 'ايجار للمتر المربع';
                    $type = 'new';
                    $value = $request['value'][9];
                }
                if ($x == 12) {
                    $key = 'new_10';
                    $name = 'معدل الاشغال';
                    $type = 'new';
                    $value = $request['value'][10];
                }
                if ($x == 13) {
                    $key = 'new_11';
                    $name = 'القيمة الحالية';
                    $type = 'new';
                    $value = $request['value'][7];
                }
//

                if ($x == 14) {
                    $key = 'old_4';
                    $name = 'صافي الايجار السنوي';
                    $type = 'old';

                    $old_3 = Investment::where([['estate_id', $request->estate_id], ['key', 'old_3']])->first();
                    $value = (float)$old_3->value - (float)$request['value'][1];
                }
                if ($x == 15) {
                    $key = 'old_5';
                    $name = 'صافي الايجار السنوي للمتر المربع';
                    $type = 'old';

                    $old_4 = Investment::where([['estate_id', $request->estate_id], ['key', 'old_4']])->first();
                    $value = (float)$request['value'][1] / (float)$old_4->value;
                }
                if ($x == 16) {
                    $key = 'old_7';
                    $name = 'الفتره المتبقية لانهاء العقد';
                    $type = 'old';
                    $value = now()->diffInDays($request['value'][3]) / 365;
                }


                if ($x == 17) {
                    $key = 'old_10';
                    $name = 'القيمة السوقية';
                    $type = 'old';

                    $old_4 = Investment::where([['estate_id', $request->estate_id], ['key', 'old_4']])->first();
                    $old_9 = Investment::where([['estate_id', $request->estate_id], ['key', 'old_9']])->first();
                    $value = (float)$old_4->value * (float)$old_9->value;
                }

                if ($x == 18) {
                    $key = 'new_3';
                    $name = 'اجمالي الايجار السنوي';
                    $type = 'new';
                    $new_1 = Investment::where([['estate_id', $request->estate_id], ['key', 'new_1']])->first();
                    $value = (float)$request['value'][0] * (float)$new_1->value;
                }

                if ($x == 19) {
                    $key = 'new_2';
                    $name = 'اجمالي المصاريف التشغيلية';
                    $type = 'new';

                    $new_8 = Investment::where([['estate_id', $request->estate_id], ['key', 'new_8']])->first();
                    $new_3 = Investment::where([['estate_id', $request->estate_id], ['key', 'new_3']])->first();
                    $value = (float)$new_8->value * (float)$new_3->value;
                }

                if ($x == 20) {
                    $key = 'new_4';
                    $name = 'صافي الايجار السنوي';
                    $type = 'new';
                    $new_2 = Investment::where([['estate_id', $request->estate_id], ['key', 'new_2']])->first();
                    $new_3 = Investment::where([['estate_id', $request->estate_id], ['key', 'new_3']])->first();
                    $value = (float)$new_2->value - (float)$new_3->value;
                }

                if ($x == 21) {
                    $key = 'new_6';
                    $name = 'عامل سنوات الشراء للابد';
                    $type = 'new';

                    $new_5 = Investment::where([['estate_id', $request->estate_id], ['key', 'new_5']])->first();
                    $new_11 = Investment::where([['estate_id', $request->estate_id], ['key', 'new_11']])->first();

                    $value = (float)$new_5->value * (float)$new_11->value;
                }
                if ($x == 22) {
                    $key = 'new_7';
                    $name = 'القيمة السوقية';
                    $type = 'new';

                    $new_4 = Investment::where([['estate_id', $request->estate_id], ['key', 'new_4']])->first();
                    $new_10 = Investment::where([['estate_id', $request->estate_id], ['key', 'new_10']])->first();
                    $new_6 = Investment::where([['estate_id', $request->estate_id], ['key', 'new_6']])->first();
                    $value = (float)$new_4->value * (float)$new_10->value * (float)$new_6->value;
                }

                if ($x == 23) {
                    $key = 'new_9';
                    $name = 'ايجار سنوي للمتر المربع';
                    $type = 'new';

                    $new_4 = Investment::where([['estate_id', $request->estate_id], ['key', 'new_4']])->first();
                    $value = (float)$request['value'][0] / (float)$new_4->value;
                }
                if ($x == 24) {
                    $key = 'total';
                    $name = 'اجمالي القيمة السوقية';
                    $type = 'total';

                    $old_10 = Investment::where([['estate_id', $request->estate_id], ['key', 'old_10']])->first();
                    $new_7 = Investment::where([['estate_id', $request->estate_id], ['key', 'new_7']])->first();
                    $value = (float)$old_10->value + (float)$new_7->value;
                }

                $in = new Investment();
                $in->key = $key;
                $in->name = $name;
                $in->type = $type;
                $in->value = $value;
                $in->estate_id = $request->estate_id;
                $in->save();
            }

            DB::commit();
            return redirect()->route('investments.show' , ['id'=>$request->estate_id,'subdomain'=>Route::current()->parameter('subdomain')])->with('done', 'تم الاضافة بالنجاح ....');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error Try Again !!');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain,$id)
    {
        $estate = Estate::find($id);
        if($estate){
            $option = Investment::where('estate_id' , $id)->get();
            return view('frontend.incomes.investments.show', compact('estate' , 'option'));
        }
        return redirect()->route('home')->with('error','عقار غير مسجل');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain,$id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain,Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain,$id)
    {
        try{
            DB::table('investments')->where('estate_id' , $id)->delete();
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'error' => 'NO Record TO DELETE'
            ]);
        }

    }
    public function delete($id)
    {
        DB::table('investments')->where('estate_id' , $id)->delete();
        return redirect()->route('investments.create')->with('done','تم الحذف بنجاح');
    }
}
