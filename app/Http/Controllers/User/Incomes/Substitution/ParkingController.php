<?php

namespace App\Http\Controllers\User\Incomes\Substitution;

use DB;
use App\Models\Estate;
use App\Models\EstateInput;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Incomes\subsitiution\Parking;
use Illuminate\Support\Facades\Route;

class ParkingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $types = Parking::where('type', 'main')->orderBy('id', 'desc')->pluck('estate_id');
            $estates = Estate::whereIn('id',$types)->get();
            return view('frontend.incomes.substitution.parking.index', compact('types','estates'));
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
            $types = Parking::where('type', 'main')->orderBy('id', 'desc')->pluck('estate_id');
            $estates = Estate::whereNotIn('id',$types)->get();
            return view('frontend.incomes.substitution.parking.creat', compact('estates'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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
            for ($x = 0; $x <= 28; $x++) {
                if ($x == 0) {
                    $key = 'main_cat';
                    $name = 'التصنيف العام';
                    $type = 'main';
                    $value = $request['value'][0];
                }
                if ($x == 1) {
                    $key = 'details';
                    $name = 'التصنيف التفصيلي';
                    $type = 'main';
                    $value = $request['value'][1];
                }
                if ($x == 2) {
                    $key = 'class';
                    $name = 'الفئة/التحسينات';
                    $type = 'main';
                    $value = $request['value'][2];
                }
                if ($x == 3) {
                    $key = 'superficial_parking';
                    $name = 'مواقف سطحية';
                    $type = 'main';
                    $value = $request['value'][3];
                }
                if ($x == 4) {
                    $key = 'multi_parking';
                    $name = 'مواقف متعددة الطوابق';
                    $type = 'main';
                    $value = $request['value'][4];
                }
//
                if ($x == 5) {
                    $key = 'underground_parking';
                    $name = 'مواقف تحت الأرض';
                    $type = 'main';
                    $value = $request['value'][5];
                }
                if ($x == 6) {
                    $key = 'land_space';
                    $name = 'مساحة الأرض';
                    $type = 'general';
                    $value = $request['value'][6];
                }
                if ($x == 7) {
                    $key = 'total_multi_parking';
                    $name = 'اجمالي مساحة المباني متعددة الطوابق';
                    $type = 'general';
                    $value = $request['value'][7];
                }
                if ($x == 8) {
                    $key = 'cost_multi_parking';
                    $name = 'اجمالي تكلفة المباني متعددة الطوابق';
                    $type = 'general';
                    $value = $request['value'][8];
                }
                if ($x == 9) {
                    $key = 'total_underground_parking';
                    $name = 'اجمالي مساحة المباني تحت الأرض';
                    $type = 'general';
                    $value = $request['value'][9];
                }

                if ($x == 10) {
                    $key = 'cost_underground_parking';
                    $name = 'اجمالي تكلفة المباني تحت الأرض';
                    $type = 'general';
                    $value = $request['value'][10];
                }
                if ($x == 11) {
                    $key = 'total_superficial_parking';
                    $name = 'اجمالي مساحة الموقف السطحية';
                    $type = 'general';

                    $value = (float)$request['value'][11];
                }

                if ($x == 12) {
                    $key = 'cost_superficial_parking';
                    $name = 'اجمالي تكلفة الموقف السطحية';
                    $type = 'general';
                    $value = $request['value'][12];
                }

                if ($x == 13) {
                    $key = 'total_builds';
                    $name = 'مجموع تكاليف البناء (بدون تكاليف التمويل)';
                    $type = 'general';

                    $value = $request['value'][13];
                }

                if ($x == 14) {
                    $key = 'development';
                    $name = 'مدة التطوير';
                    $type = 'general';
                    $value = $request['value'][14];
                }

                if ($x == 15) {
                    $key = 'yearly_benefit';
                    $name = 'معدل الفائدة على التمويل سنويا';
                    $type = 'general';

                    $value = $request['value'][15];
                }

                if ($x == 16) {
                    $key = 'financing_development';
                    $name = 'نسبة التمويل من مدة التطوير';
                    $type = 'general';
                    $value = $request['value'][16];
                }

                if ($x == 17) {
                    $key = 'financing_benefit';
                    $name = 'نسبة التمويل من تكلفة التمويل';
                    $type = 'general';

                    $value = $request['value'][17];
                }
                if ($x == 18) {
                    $key = 'cost_financing';
                    $name = 'اجمالي تكلفة التمويل';
                    $type = 'general';

                    $value = $request['value'][18];
                }

                if ($x == 19) {
                    $key = 'total_financing';
                    $name = 'القيمة الاجمالية للتطوير';
                    $type = 'general';

                    $value = $request['value'][19];
                }
                if ($x == 20) {
                    $key = 'default_age';
                    $name = 'العمر الافتراضي للمبنى';
                    $type = 'general_build';

                    $value = $request['value'][20];
                }
                if ($x == 21) {
                    $key = 'remaining_age';
                    $name = 'العمر المتبقي للمبنى';
                    $type = 'general_build';

                    $value = $request['value'][21];
                }
                if ($x == 22) {
                    $key = 'yearly_depreciation';
                    $name = 'معدل الاهلاك السنوي (العمر الممتد)';
                    $type = 'general_build';

                    $value = $request['value'][22];
                }
                if ($x == 23) {
                    $key = 'total_development';
                    $name = 'اجمالي قيمة التطوير';
                    $type = 'general_build';

                    $value = $request['value'][23];
                }
                if ($x == 24) {
                    $key = 'depreciation';
                    $name = 'قيمة الاهلاك';
                    $type = 'general_build';

                    $value = $request['value'][24];
                }
                if ($x == 25) {
                    $key = 'builds_after_depreciation';
                    $name = 'قيمة المباني بعد الاهلاك';
                    $type = 'general_build';

                    $value = $request['value'][25];
                }
                if ($x == 26) {
                    $key = 'comparison_land';
                    $name = 'قيمة الارض بطريقة المقارنة';
                    $type = 'total';

                    $value = $request['value'][26];
                }
                if ($x == 27) {
                    $key = 'total_builds_after_depreciation';
                    $name = 'اجمالي قيمة المباني بعد الاهلاك';
                    $type = 'total';

                    $value = $request['value'][27];
                }
                if ($x == 28) {
                    $key = 'substitution_bulids';
                    $name = 'قيمة العقار بطريقة الاحلال';
                    $type = 'total';

                    $value = $request['value'][28];
                }

                $in = new Parking();
                $in->key = $key;
                $in->name = $name;
                $in->type = $type;
                $in->value = $value;
                $in->estate_id = $request->estate_id;
                $in->save();
            }

            DB::commit();
            return redirect()->route('parking.show' , ['id'=>$request->estate_id,'subdomain'=>Route::current()->parameter('subdomain')])->with('done', 'تم الاضافة بالنجاح ....');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain,$id)
    {
        $estate = Estate::find($id);
        if($estate){
            $option = Parking::where('estate_id' , $id)->get();
            return view('frontend.incomes.substitution.parking.show', compact('estate' , 'option'));
        }
        return redirect()->route('home',$subdomain)->with('error','عقار غير مسجل');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain,Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain,$id)
    {
        try{
            DB::table('parkings')->where('estate_id' , $id)->delete();
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'error' => 'NO Record TO DELETE'
            ]);
        }
    }

    public function delete($subdomain,$id)
    {
        DB::table('parkings')->where('estate_id' , $id)->delete();
        return redirect()->route('land.create',$subdomain)->with('done','تم الحذف بنجاح');
    }
}
