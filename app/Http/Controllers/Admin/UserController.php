<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Address;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
//    function __construct()
//    {
//        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index','show' , 'tree']]);
//        $this->middleware('permission:category-list', ['only' => ['index','show' , 'tree']]);
//        $this->middleware('permission:category-create', ['only' => ['create','store']]);
//        $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:category-delete', ['only' => ['destroy' , 'delete_categories']]);
//    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $users = User::orderBy('id', 'desc')->get();
            return view('backend.users.index',compact('users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }
    public function blocked()
    {
        try {
            $users = User::orderBy('id', 'desc')->where('active' , 0)->get();
            return view('backend.users.blocked',compact('users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }
    public function block_user($slug)
    {
        try {
            $user = User::where('slug' , $slug)->first();
            if($user->active == 1){
                $user->active = 0;
                $user->save();
                return redirect()->back()->with('error', 'تم حظر المستخدم ....');
            }else{
                $user->active = 1;
                $user->save();
                return redirect()->back()->with('done', 'تم ازالة الحظر ....');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
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
            return view('backend.users.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            if($request->active){
                $request->request->add(['active' => 1]);
            }else{
                $request->request->add(['active' => 0]);
            }
            $request->request->add(['password' => Hash::make($request->password)]);
            User::create($request->all());
            return redirect()->route('users.index')->with('done', 'تم الاضافة بنجاح ....');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $user = User::where('slug' , $slug)->first();
        if (isset($user)) {
            return view('backend.users.show', compact('user'));
        } else {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $user = User::where('slug',$slug)->first();
        if (isset($user)) {
            return view('backend.users.edit', compact('user'));
        } else {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        try {
            $user = User::find($id);
            if($request->active){
                $request->request->add(['active' => 1]);
            }else{
                $request->request->add(['active' => 0]);
            }
            if($request->password){
                $request->request->add(['password' => Hash::make($request->password)]);
            }else{
                $request->request->add(['password' => $user->password]);
            }
            $user->update($request->all());
            return redirect()->route('users.index')->with('done', 'تم التعديل بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);
            $user->delete();
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }

    }

    public function delete_users()
    {
        try {
            $users = User::all();
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $user->delete();
                }
                return response()->json([
                    'success' => 'Record deleted successfully!'
                ]);
            } else {
                return response()->json([
                    'error' => 'NO EVENTS TO DELETE'
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }
}
