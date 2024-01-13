<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories = Category::orderBy('id', 'desc')->get();
            return view('frontend.categories.index',compact('categories'));
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
            return view('frontend.categories.create');
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
    public function store($subdomain,Request $request)
    {
        try {
            $city = new Category();
            $city->name = $request->name;
            $city->active = $request->active ? 1 : 0;
            $city->save();
            return redirect()->route('categories.index',$subdomain)->with('done', 'تم الاضافة بالنجاح ....');
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
    public function edit($subdomain,$category)
    {

        $category = Category::find($category);
        if(isset($category)){
            return view('frontend.categories.edit' , compact('category'));
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
    public function update($subdomain,Request $request, $id)
    {
        try{
            $category = Category::find($id);
            $category->name = $request->name;
            $category->active = $request->active ? 1 : 0;
            $category->save();
            return redirect()->route('categories.index',$subdomain)->with('done' , 'تم التعديل بنجاح ....');
        }catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
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
            $city = Category::find($id);
            $city->delete();
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    public function delete_categories()
    {
        try{
            $categories = Category::all();
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
