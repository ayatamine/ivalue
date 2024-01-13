<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $permissions = Permission::all();
            return view('frontend.permissions.index',compact('permissions'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('frontend.permissions.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($subdomain,Request $request)
    {
        $this->validate($request,
        [
            'name'=>'string|required|max:190|unique:'.config('permission.table_names.permissions', 'permissions').',name',
        ]);
        try {
            $Permission  = Permission::create(['name'=>$request->name]);
            if(! empty($request->permissions)) {
                $Permission->givePermissionTo($request->permissions);
            }
            return redirect()->route('permissions.index',$subdomain)->with('done', 'تم الانشاء بنجاح ....');
        }  catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($subdomain,$permission)
    {
        $permission =Permission::findById($permission);
        if (isset($permission)) {

            return view('frontend.permissions.edit', compact('permission'));
        } else {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($subdomain,Request $request, $Permission)
    {
        $Permission = Permission::findById($Permission);
        $this->validate($request,
        [
            'name'=>'string|required|max:190|unique:'.config('permission.table_names.permissions', 'permissions').',name,'.$Permission->id,
        ]);

        if (isset($Permission)) {


            $Permission->update(['name'=>$request->name]);
            return back()->with('done', 'تم التعديل بنجاح ....');
        } else {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($subdomain,string $id)
    {
        try {
            $Permission = Permission::find($id);
            $Permission->delete();
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }
}
