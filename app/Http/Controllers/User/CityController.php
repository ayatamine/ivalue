<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityRequest;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

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
            $countries = Country::all();
            return view('frontend.cities.create' , compact('countries'));
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
            $countries = Country::all();
            return view('frontend.cities.edit' , compact('city' , 'countries'));
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
        $cities = City::where('country_id', $country)->get();
        return response()->json($cities);
    }
}
