<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ZoneRequest;
use App\Models\Zone;
use App\Models\Country;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $zones = Zone::orderBy('id', 'desc')->get();
            return view('frontend.zones.index',compact('zones'));
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
            return view('frontend.zones.create' , compact('countries'));
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
    public function store($subdomain,ZoneRequest $request)
    {
        try {
            if($request->active){
                $request->request->add(['active' => 1]);
            }else{
                $request->request->add(['active' => 0]);
            }
            Zone::create($request->all());
            return redirect()->route('zones.index',$subdomain)->with('done', 'تم الاضافة بالنجاح ....');
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
        $zone = Zone::find($id);
        if(isset($zone)){
            $countries = Country::all();
            return view('frontend.zones.edit' , compact('zone' , 'countries'));
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
    public function update($subdomain,ZoneRequest $request, $id)
    {
        try{
            $zone = Zone::find($id);
            if($request->active){
                $request->request->add(['active' => 1]);
            }else{
                $request->request->add(['active' => 0]);
            }
            $zone->update($request->all());
            return redirect()->route('zones.index',$subdomain)->with('done' , 'تم التعديل بنجاح ....');
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
            $zone = Zone::find($id);
            $zone->delete();
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    public function delete_zones()
    {
        try{
            $zones = Zone::all();
            if(count($zones) > 0){
                foreach ($zones as $zone){
                    $zone->delete();
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
    public function countryZones($country)
    {
        $zones = Zone::where('country_id', $country)->get();
        return response()->json($zones);
    }
}
