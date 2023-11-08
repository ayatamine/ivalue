<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Technique;
use App\Models\TechniqueType;
use Illuminate\Http\Request;

class TechniqueTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories = TechniqueType::orderBy('id', 'desc')->get();
            return view('frontend.technique_types.index',compact('categories'));
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
            $techniques = Technique::all();
            return view('frontend.technique_types.create',compact('techniques'));
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
        try {
            $city = new TechniqueType();
            $city->name = $request->name;
            $city->technique_id = $request->technique_id;
            $city->active = $request->active ? 1 : 0;
            $city->save();
            return redirect()->route('technique-types.index')->with('done', 'تم الاضافة بالنجاح ....');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = TechniqueType::find($id);
        if(isset($category)){
            $techniques = Technique::all();
            return view('frontend.technique_types.edit' , compact('category','techniques'));
        }else{
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
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
        try{
            $city = TechniqueType::find($id);
            $city->name = $request->name;
            $city->technique_id = $request->technique_id;
            $city->active = $request->active ? 1 : 0;
            $city->save();
            return redirect()->route('technique-types.index')->with('done' , 'تم التعديل بنجاح ....');
        }catch (\Exception $e){
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
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
            $city = TechniqueType::find($id);
            $city->delete();
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    public function delete_technique_types()
    {
        try{
            $categories = TechniqueType::all();
            if(count($categories) > 0){
                foreach ($categories as $city){
                    $city->delete();
                }
                return response()->json([
                    'success' => 'Record deleted successfully!'
                ]);
            }else{
                return response()->json([
                    'error' => 'NO Record TO DELETE'
                ]);
            }
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }
}
