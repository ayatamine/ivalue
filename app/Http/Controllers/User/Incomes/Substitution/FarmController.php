<?php

namespace App\Http\Controllers\User\Incomes\Substitution;

use App\Http\Controllers\Controller;
use App\Incomes\subsitiution\Farm;
use App\Models\Estate;
use App\Models\EstateInput;
use Illuminate\Http\Request;
use DB;

class FarmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $types = Farm::where('type', 'main')->orderBy('id', 'desc')->pluck('estate_id');
            $estates = Estate::whereIn('id',$types)->get();
            return view('frontend.incomes.substitution.farm.index', compact('types','estates'));
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
            $types = Farm::where('type', 'main')->orderBy('id', 'desc')->pluck('estate_id');
            $estates = Estate::whereNotIn('id',$types)->get();
            return view('frontend.incomes.substitution.farm.creat', compact('estates'));
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
            for ($x = 0; $x <= 49; $x++) {
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
                    $key = 'worker_home';
                    $name = 'سكن عمال (مباني)';
                    $type = 'main';
                    $value = $request['value'][3];
                }
                if ($x == 4) {
                    $key = 'warehouses';
                    $name = 'مستودعات (مباني)';
                    $type = 'main';
                    $value = $request['value'][4];
                }
//
                if ($x == 5) {
                    $key = 'conventional_wells';
                    $name = 'آبار تقليدية';
                    $type = 'main';
                    $value = $request['value'][5];
                }
                if ($x == 6) {
                    $key = 'artesian_wells';
                    $name = 'آبار ارتوازية';
                    $type = 'main';
                    $value = $request['value'][6];
                }
                if ($x == 7) {
                    $key = 'upper_cabinets';
                    $name = 'الخزانات العلوية';
                    $type = 'main';
                    $value = $request['value'][7];
                }
                if ($x == 8) {
                    $key = 'underground_tanks';
                    $name = 'الخزانات الأرضية';
                    $type = 'main';
                    $value = $request['value'][8];
                }
                if ($x == 9) {
                    $key = 'puddles_water';
                    $name = 'برك ماء';
                    $type = 'main';
                    $value = $request['value'][9];
                }
                if ($x == 10) {
                    $key = 'earthen_infertility';
                    $name = 'العقوم الترابية';
                    $type = 'main';
                    $value = $request['value'][10];
                }
                if ($x == 11) {
                    $key = 'agricultural_terraces';
                    $name = 'المدرجات الزراعية';
                    $type = 'main';
                    $value = $request['value'][11];
                }
                if ($x == 12) {
                    $key = 'walls';
                    $name = 'الاسوار';
                    $type = 'main';
                    $value = $request['value'][12];
                }
//
                if ($x == 13) {
                    $key = 'total_land';
                    $name = 'مساحه الارض';
                    $type = 'general';
                    $value = $request['value'][13];
                }
                if ($x == 14) {
                    $key = 'total_worker_home_size';
                    $name = 'اجمالي مساحة المباني (سكن العمال)';
                    $type = 'general';

                    $value = (float)$request['value'][14];
                }
                if ($x == 15) {
                    $key = 'total_worker_home_cost';
                    $name = 'اجمالي تكلفة المباني (سكن عمال)';
                    $type = 'general';
                    $value = $request['value'][15];
                }
                if ($x == 16) {
                    $key = 'total_wall_size';
                    $name = 'اجمالي طول السور';
                    $type = 'general';

                    $value = $request['value'][16];
                }

                if ($x == 17) {
                    $key = 'wall_total_cost';
                    $name = 'اجمالي تكلفة السور';
                    $type = 'general';
                    $value = $request['value'][17];
                }

                if ($x == 18) {
                    $key = 'earthen_infertility_size';
                    $name = 'اجمالي طول العقم الترابي';
                    $type = 'general';

                    $value = $request['value'][18];
                }

                if ($x == 19) {
                    $key = 'earthen_infertility_cost';
                    $name = 'اجمالي تكلفة العقم الترابي';
                    $type = 'general';
                    $value = $request['value'][19];
                }

                if ($x == 20) {
                    $key = 'total_warehouses_size';
                    $name = 'مساحة المستودعات';
                    $type = 'general';

                    $value = $request['value'][20];
                }
                if ($x == 21) {
                    $key = 'total_warehouses_cost';
                    $name = 'اجمالي تكلفة المستودعات';
                    $type = 'general';

                    $value = $request['value'][21];
                }

                if ($x == 22) {
                    $key = 'total_agricultural_terraces_size';
                    $name = 'اجمالي مساحة المدرجات الزراعية';
                    $type = 'general';

                    $value = $request['value'][22];
                }
                if ($x == 23) {
                    $key = 'total_agricultural_terraces_cost';
                    $name = 'اجمالي تكلفة المدرجات الزراعية';
                    $type = 'general';
                    $value = $request['value'][23];
                }

                if ($x == 24) {
                    $key = 'total_puddles_water_size';
                    $name = 'اجمالي مساحة البرك المائية';
                    $type = 'general_farm';

                    $value = $request['value'][24];
                }
                if ($x == 25) {
                    $key = 'total_puddles_water_cost';
                    $name = 'اجمالي تكلفة البرك المائية';
                    $type = 'general';
                    $value = $request['value'][25];
                }
                if ($x == 26) {
                    $key = 'underground_tanks_size';
                    $name = 'اجمالي حجم الخزانات الأرضية';
                    $type = 'general';
                    $value = $request['value'][26];
                }
                if ($x == 27) {
                    $key = 'underground_tanks_cost';
                    $name = 'اجمالي تكلفة الخزانات الأرضية';
                    $type = 'general';

                    $value = $request['value'][27];
                }
                if ($x == 28) {
                    $key = 'upper_cabinets_size';
                    $name = 'اجمالي حجم الخزانات العلوية';
                    $type = 'general';

                    $value = $request['value'][28];
                }
                if ($x == 29) {
                    $key = 'upper_cabinets_cost';
                    $name = 'اجمالي تكلفة الخزانات العلوية';
                    $type = 'general';

                    $value = $request['value'][29];
                }
                if ($x == 30) {
                    $key = 'artesian_wells_size';
                    $name = 'اجمالي طول ابيار الارتواز';
                    $type = 'general';

                    $value = $request['value'][30];
                }
                if ($x == 31) {
                    $key = 'artesian_wells_cost';
                    $name = 'اجمالي تكلفة ابيار الارتواز';
                    $type = 'general';

                    $value = $request['value'][31];
                }
                if ($x == 32) {
                    $key = 'conventional_wells_size';
                    $name = 'اجمالي حجم الابيار التقيدية';
                    $type = 'general';

                    $value = $request['value'][32];
                }
                if ($x == 33) {
                    $key = 'conventional_wells_cost';
                    $name = 'اجمالي تكلفة الابيار التقليدية';
                    $type = 'general';

                    $value = $request['value'][33];
                }
                if ($x == 34) {
                    $key = 'total_farms_cost';
                    $name = 'مجموع تكاليف البناء (بدون تكاليف التمويل)';
                    $type = 'general';

                    $value = $request['value'][34];
                }

                if ($x == 35) {
                    $key = 'development';
                    $name = 'مدة التطوير';
                    $type = 'general';
                    $value = $request['value'][35];
                }

                if ($x == 36) {
                    $key = 'yearly_benefit';
                    $name = 'معدل الفائدة على التمويل سنويا';
                    $type = 'general';

                    $value = $request['value'][36];
                }

                if ($x == 37) {
                    $key = 'financing_development';
                    $name = 'نسبة التمويل من مدة التطوير';
                    $type = 'general';
                    $value = $request['value'][37];
                }

                if ($x == 38) {
                    $key = 'financing_benefit';
                    $name = 'نسبة التمويل من تكلفة التمويل';
                    $type = 'general';

                    $value = $request['value'][38];
                }
                if ($x == 39) {
                    $key = 'cost_financing';
                    $name = 'اجمالي تكلفة التمويل';
                    $type = 'general';

                    $value = $request['value'][39];
                }

                if ($x == 37) {
                    $key = 'total_financing';
                    $name = 'القيمة الاجمالية للتطوير';
                    $type = 'general';

                    $value = $request['value'][40];
                }
//
                if ($x == 41) {
                    $key = 'default_age';
                    $name = 'العمر الافتراضي للمبنى';
                    $type = 'general_farm';

                    $value = $request['value'][41];
                }
                if ($x == 42) {
                    $key = 'remaining_age';
                    $name = 'العمر المتبقي للمبنى';
                    $type = 'general_farm';

                    $value = $request['value'][42];
                }
                if ($x == 43) {
                    $key = 'yearly_depreciation';
                    $name = 'معدل الاهلاك السنوي (العمر الممتد)';
                    $type = 'general_farm';

                    $value = $request['value'][43];
                }
                if ($x == 44) {
                    $key = 'total_development';
                    $name = 'اجمالي قيمة التطوير';
                    $type = 'general_farm';

                    $value = $request['value'][44];
                }
                if ($x == 45) {
                    $key = 'depreciation';
                    $name = 'قيمة الاهلاك';
                    $type = 'general_farm';

                    $value = $request['value'][45];
                }
                if ($x == 46) {
                    $key = 'farms_after_depreciation';
                    $name = 'قيمة المباني بعد الاهلاك';
                    $type = 'general_farm';

                    $value = $request['value'][46];
                }
//
                if ($x == 47) {
                    $key = 'comparison_land';
                    $name = 'قيمة الارض بطريقة المقارنة';
                    $type = 'total';

                    $value = $request['value'][47];
                }
                if ($x == 48) {
                    $key = 'total_farms_after_depreciation';
                    $name = 'اجمالي قيمة المباني بعد الاهلاك';
                    $type = 'total';

                    $value = $request['value'][48];
                }
                if ($x == 49) {
                    $key = 'substitution_bulids';
                    $name = 'قيمة العقار بطريقة الاحلال';
                    $type = 'total';
                    $value = $request['value'][49];
                }

                $in = new Farm();
                $in->key = $key;
                $in->name = $name;
                $in->type = $type;
                $in->value = $value;
                $in->estate_id = $request->estate_id;
                $in->save();
            }

            DB::commit();
            return redirect()->route('farm.show' , $request->estate_id)->with('done', 'تم الاضافة بالنجاح ....');
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
            $option = Farm::where('estate_id' , $id)->get();
            return view('frontend.incomes.substitution.farm.show', compact('estate' , 'option'));
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
            DB::table('farms')->where('estate_id' , $id)->delete();
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
        DB::table('farms')->where('estate_id' , $id)->delete();
        return redirect()->route('farm.create')->with('done','تم الحذف بنجاح');
    }
}
