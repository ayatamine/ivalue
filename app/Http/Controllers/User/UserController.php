<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Address;
use App\Traits\UploadTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use UploadTrait;
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
    public function admins()
    {
        try {
            $users = User::where('membership_level','!=','client')->orderBy('id', 'desc')->get();
            return view('frontend.users.index',compact('users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }
    public function index()
    {
        try {
            $users = User::where('membership_level','client')->orderBy('id', 'desc')->get();
            return view('frontend.users.index',compact('users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }
    public function blocked()
    {
        try {
            $users = User::orderBy('id', 'desc')->where('active' , 0)->get();
            return view('frontend.users.blocked',compact('users'));
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
            return view('frontend.users.create');
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
            $user = new User();

            if ($request->hasFile('image')) {
                $this->saveimage($request->image, 'pictures/users', $user->id , User::class, 'image');
            }

            $user->name = $request->name;
            $user->password = Hash::make($request->password);;
            $user->email = $request->email;
            $user->phone_1 = $request->phone_1;
            $user->phone_2 = $request->phone_2;
            $user->mobile_1 = $request->mobile_1;
            $user->mobile_2 = $request->mobile_2;

            $length = 25;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $user->membership_no = $randomString;
            $user->membership_level = $request->membership_level;

            if($user->membership_level == 'client'){
                $user->estate = 1;
            }
            if($user->membership_level != 'client'){
                $user->membership_expire = $request->membership_expire;
                $user->contract_expire = $request->contract_expire;
                $user->contract_delay = $request->contract_delay;
                $user->estate = 1;
                $user->contract_automatic_reactive = $request->contract_automatic_reactive ? 1 : 0;

                if ($request->hasFile('contract_image')) {
                    $this->saveimage($request->contract_image, 'pictures/users', $user->id , User::class, 'contract_image');
                }

                if ($request->hasFile('signature_image')) {
                    $this->saveimage($request->signature_image, 'pictures/users', $user->id , User::class, 'signature_image');
                }

            }
            $user->active = $request->active ? 1 : 0;
            $request->request->add(['password' => Hash::make($request->password)]);
            $user->save();
            if($user->membership_level == 'client'){
                return redirect()->route('users.index')->with('done', 'تم الاضافة بنجاح ....');
            }else{
                return redirect()->route('admins')->with('done', 'تم الاضافة بنجاح ....');
            }
            
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
            return view('frontend.users.show', compact('user'));
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
            return view('frontend.users.edit', compact('user'));
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
            if ($request->hasFile('image')) {
                $this->saveimage($request->image, 'pictures/users', $user->id , User::class, 'image');
            }

            $user->name = $request->name;
            $user->password = Hash::make($request->password);;
            $user->email = $request->email;
            $user->phone_1 = $request->phone_1;
            $user->phone_2 = $request->phone_2;
            $user->mobile_1 = $request->mobile_1;
            $user->mobile_2 = $request->mobile_2;

            $length = 25;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $user->membership_no = $randomString;
            $user->membership_level = $request->membership_level;

            if($user->membership_level == 'client'){
                $user->estate = 1;
            }
            if($user->membership_level != 'client'){
                $user->membership_expire = $request->membership_expire;
                $user->contract_expire = $request->contract_expire;
                $user->contract_delay = $request->contract_delay;
                $user->estate = 1;
                $user->contract_automatic_reactive = $request->contract_automatic_reactive ? 1 : 0;

                if ($request->hasFile('contract_image')) {
                    $this->saveimage($request->contract_image, 'pictures/users', $user->id , User::class, 'contract_image');
                }

                if ($request->hasFile('signature_image')) {
                    $this->saveimage($request->signature_image, 'pictures/users', $user->id , User::class, 'signature_image');
                }

            }
            $user->active = $request->active ? 1 : 0;
            $request->request->add(['password' => Hash::make($request->password)]);
            $user->save();
             if($user->membership_level == 'client'){
                return redirect()->route('users.index')->with('done', 'تم التعديل بنجاح');
            }else{
                return redirect()->route('admins')->with('done', 'تم التعديل بنجاح ....');
            }
          
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
