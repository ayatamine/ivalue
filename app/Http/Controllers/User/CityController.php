<?php

namespace App\Http\Controllers\User;

use App\Models\City;
use App\Models\Zone;
use Illuminate\Http\Request;
use App\Http\Requests\CityRequest;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $cities = City::orderBy('id', 'desc')->get();
            return view('frontend.cities.index',compact('cities'));
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
            $zones = Zone::all();
            return view('frontend.cities.create' , compact('zones'));
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
    public function store($subdomain,CityRequest $request)
    {
        try {
            if($request->active){
                $request->request->add(['active' => 1]);
            }else{
                $request->request->add(['active' => 0]);
            }
            City::create($request->all());
            return redirect()->route('cities.index',$subdomain)->with('done', 'تم الاضافة بالنجاح ....');
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
    public function edit($subdomain,$id)
    {
        $city = City::find($id);
        if(isset($city)){
            $zones = Zone::all();
            return view('frontend.cities.edit' , compact('city' , 'zones'));
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
    public function update($subdomain,CityRequest $request, $id)
    {
        try{
            $city = City::find($id);
            if($request->active){
                $request->request->add(['active' => 1]);
            }else{
                $request->request->add(['active' => 0]);
            }
            $city->update($request->all());
            return redirect()->route('cities.index',$subdomain)->with('done' , 'تم التعديل بنجاح ....');
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
    public function destroy($subdomain,$id)
    {
        try{
            $city = City::find($id);
            $city->delete();
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    public function delete_cities()
    {
        try{
            $cities = City::all();
            if(count($cities) > 0){
                foreach ($cities as $city){
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
    public function countryCities($country)
    {
        $cities = City::whereIn('zone_id', [Zone::whereCountryId($country)->pluck('country_id')])->get();
        return response()->json($cities);
    }
}
