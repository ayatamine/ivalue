<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $roles = Role::all();
            return view('frontend.roles.index',compact('roles'));
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
        return view('frontend.roles.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($subdomain,Request $request)
    {
        $this->validate($request,
        [
            'name'=>'string|required|max:190|unique:'.config('permission.table_names.roles', 'roles').',name',
        ]);
        try {
            $role  = Role::create(['name'=>$request->name]);
            if(! empty($request->permissions)) {
                $role->givePermissionTo($request->permissions);
            }
            return redirect()->route('roles.index',$subdomain)->with('done', 'تم الانشاء بنجاح ....');
        }  catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($subdomain,string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($subdomain,string $id)
    {

        if (isset($id)) {
            $role = Role::findOrFail($id);
            $permissions = Permission::all();
            $roleHasPermissions = array_column(json_decode($role->permissions, true), 'id');
            return view('frontend.roles.edit', compact('role','permissions','roleHasPermissions'));
        } else {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($subdomain,Request $request, $role)
    {
        $role = Role::findById($role);
        $this->validate($request,
        [
            'name'=>'string|required|max:190|unique:'.config('permission.table_names.roles', 'roles').',name,'.$role->id,
        ]);
        if (isset($role)) {

            // $role = Role::find($id);
            $role->update(['name'=>$request->name]);
            $permissions = $request->permissions ?? [];
            $role->syncPermissions($permissions);
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
            $role = Role::find($id);
            $role->delete();
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }
}
