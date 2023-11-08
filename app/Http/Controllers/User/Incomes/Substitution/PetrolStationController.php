<?php

namespace App\Http\Controllers\User\Incomes\Substitution;

use App\Http\Controllers\Controller;
use App\Incomes\subsitiution\PetrolStation;
use App\Models\Estate;
use App\Models\EstateInput;
use Illuminate\Http\Request;
use DB;

class PetrolStationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $types = PetrolStation::where('type', 'main')->orderBy('id', 'desc')->pluck('estate_id');
            $estates = Estate::whereIn('id',$types)->get();
            return view('frontend.incomes.substitution.petrol_station.index', compact('types','estates'));
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
            $types = PetrolStation::where('type', 'main')->orderBy('id', 'desc')->pluck('estate_id');
            $estates = Estate::whereNotIn('id',$types)->get();
            return view('frontend.incomes.substitution.petrol_station.creat', compact('estates'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
            for ($x = 0; $x <= 33; $x++) {
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
                    $key = 'repair_general_site';
                    $name = 'تجهيز الموقع العام';
                    $type = 'main';
                    $value = $request['value'][3];
                }
                if ($x == 4) {
                    $key = 'wall_cost';
                    $name = 'تكلفة انشاء السور';
                    $type = 'main';
                    $value = $request['value'][4];
                }
                if ($x == 5) {
                    $key = 'support_services';
                    $name = 'منطقة الخدمات المساندة';
                    $type = 'main';
                    $value = $request['value'][5];
                }
                if ($x == 6) {
                    $key = 'station_umbrella';
                    $name = 'مظلة المحطة';
                    $type = 'main';
                    $value = $request['value'][6];
                }
                if ($x == 7) {
                    $key = 'fuel_tanks';
                    $name = 'خزانات الوقود';
                    $type = 'main';
                    $value = $request['value'][7];
                }
                //
                if ($x == 8) {
                    $key = 'land_space';
                    $name = 'مساحة الأرض';
                    $type = 'general';
                    $value = $request['value'][8];
                }
                if ($x == 9) {
                    $key = 'total_support_services';
                    $name = 'اجمالي مساحة المباني المساندة';
                    $type = 'general';
                    $value = $request['value'][9];
                }
                if ($x == 10) {
                    $key = 'total_cost_preparing';
                    $name = 'اجمالي تكلفة تجهيز الموقع العام';
                    $type = 'general';
                    $value = $request['value'][10];
                }
                if ($x == 11) {
                    $key = 'total_cost_supporting';
                    $name = 'اجمالي تكلفة المباني المساندة';
                    $type = 'general';
                    $value = $request['value'][11];
                }
                if ($x == 12) {
                    $key = 'total_length_fence';
                    $name = 'اجمالي طول السور';
                    $type = 'general';
                    $value = $request['value'][12];
                }
                if ($x == 13) {
                    $key = 'total_cost_fence';
                    $name = 'اجمالي تكلفة السور';
                    $type = 'general';

                    $value = (float)$request['value'][13];
                }
                if ($x == 14) {
                    $key = 'size_tanks';
                    $name = 'حجم خزانات الوقود';
                    $type = 'general';
                    $value = $request['value'][14];
                }
                if ($x == 15) {
                    $key = 'total_cost_tanks';
                    $name = 'اجمالي تكلفة خزانات الوقود';
                    $type = 'general';
                    $value = $request['value'][15];
                }

                if ($x == 16) {
                    $key = 'size_station_umbrella';
                    $name = 'مساحة مظلة المحطة';
                    $type = 'general';
                    $value = $request['value'][16];
                }

                if ($x == 17) {
                    $key = 'cost_station_umbrella';
                    $name = 'اجمالي تكلفة مظلة المحطة';
                    $type = 'general';
                    $value = $request['value'][17];
                }

                if ($x == 18) {
                    $key = 'financing_development';
                    $name = 'مجموع تكاليف البناء (بدون تكاليف التمويل)';
                    $type = 'general';
                    $value = $request['value'][18];
                }

                if ($x == 19) {
                    $key = 'development';
                    $name = 'مدة التطوير';
                    $type = 'general';
                    $value = $request['value'][19];
                }

                if ($x == 20) {
                    $key = 'yearly_benefit';
                    $name = 'معدل الفائدة على التمويل سنويا';
                    $type = 'general';

                    $value = $request['value'][20];
                }

                if ($x == 21) {
                    $key = 'financing_development';
                    $name = 'نسبة التمويل من مدة التطوير';
                    $type = 'general';
                    $value = $request['value'][21];
                }

                if ($x == 22) {
                    $key = 'financing_benefit';
                    $name = 'نسبة التمويل من تكلفة التمويل';
                    $type = 'general';

                    $value = $request['value'][22];
                }
                if ($x == 23) {
                    $key = 'cost_financing';
                    $name = 'اجمالي تكلفة التمويل';
                    $type = 'general';

                    $value = $request['value'][23];
                }

                if ($x == 24) {
                    $key = 'total_financing';
                    $name = 'القيمة الاجمالية للتطوير';
                    $type = 'general';
                    $value = $request['value'][24];
                }
                if ($x == 25) {
                    $key = 'default_age';
                    $name = 'العمر الافتراضي للمبنى';
                    $type = 'general_build';
                    $value = $request['value'][25];
                }
                if ($x == 26) {
                    $key = 'remaining_age';
                    $name = 'العمر المتبقي للمبنى';
                    $type = 'general_build';

                    $value = $request['value'][26];
                }
                if ($x == 27) {
                    $key = 'yearly_depreciation';
                    $name = 'معدل الاهلاك السنوي (العمر الممتد)';
                    $type = 'general_build';

                    $value = $request['value'][27];
                }
                if ($x == 28) {
                    $key = 'total_development';
                    $name = 'اجمالي قيمة التطوير';
                    $type = 'general_build';

                    $value = $request['value'][28];
                }
                if ($x == 29) {
                    $key = 'depreciation';
                    $name = 'قيمة الاهلاك';
                    $type = 'general_build';

                    $value = $request['value'][29];
                }
                if ($x == 30) {
                    $key = 'builds_after_depreciation';
                    $name = 'قيمة المباني بعد الاهلاك';
                    $type = 'general_build';

                    $value = $request['value'][30];
                }
                if ($x == 31) {
                    $key = 'comparison_land';
                    $name = 'قيمة الارض بطريقة المقارنة';
                    $type = 'total';

                    $value = $request['value'][31];
                }
                if ($x == 32) {
                    $key = 'total_builds_after_depreciation';
                    $name = 'اجمالي قيمة المباني بعد الاهلاك';
                    $type = 'total';

                    $value = $request['value'][32];
                }
                if ($x == 33) {
                    $key = 'substitution_bulids';
                    $name = 'قيمة العقار بطريقة الاحلال';
                    $type = 'total';

                    $value = $request['value'][33];
                }

                $in = new PetrolStation();
                $in->key = $key;
                $in->name = $name;
                $in->type = $type;
                $in->value = $value;
                $in->estate_id = $request->estate_id;
                $in->save();
            }

            DB::commit();
            return redirect()->route('petrol_station.show' , $request->estate_id)->with('done', 'تم الاضافة بالنجاح ....');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $estate = Estate::find($id);
        if($estate){
            $option = PetrolStation::where('estate_id' , $id)->get();
            return view('frontend.incomes.substitution.petrol_station.show', compact('estate' , 'option'));
        }
        return redirect()->route('home')->with('error','عقار غير مسجل');
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            DB::table('petrol_stations')->where('estate_id' , $id)->delete();
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
        DB::table('petrol_stations')->where('estate_id' , $id)->delete();
        return redirect()->route('petrol_station.create')->with('done','تم الحذف بنجاح');
    }
}
