<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Establishment;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class EstablishmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $establishments = Establishment::with('admin')->latest()->get();
            return view('frontend.establishments.index', compact('establishments'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('frontend.establishments.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                // 'admin_id'=>'required|string|exists:user,id|unique:establishments,admin_id',
                'admin_name'=>'required|string',
                'email'=>'required|string|email|lowercase|max:255|unique:'.User::class,
                // 'password'=>'string|min:6',
                // 'name'=>'required|string',
                'name_en'=>'required|string',
                'domain'=>'required|string|unique:establishments,domain',
                'database'=>'required|string|unique:establishments,database',
                'database_username'=>'sometimes|nullable|string',
                'database_password'=>'sometimes|nullable|string',
            ]);
            DB::beginTransaction();

            $validated['password'] = $request->password ? Hash::make($request['password']) : Hash::make('123456789');
            $validated['membership_level'] = 'admin';

            $user = User::create([
                'name'=>$validated['admin_name'],
                'email'=>$validated['email'],
                'password'=>$validated['password'],
                'membership_level'=>$validated['membership_level'],
            ]);

            $establishment = new Establishment();
            $establishment->admin_id = $user->id;
            // $establishment->name = $validated['name'];
            $establishment->name_en = $validated['name_en'];
            $establishment->email = $validated['email'];
            $establishment->domain = $validated['domain'];
            $establishment->database = $validated['database'];
            $establishment->database_username = $validated['database_username'] ?? 'root';
            $establishment->database_password = $validated['database_password'] ?? '';
            $establishment->save();
            DB::Commit();

            // // //create a new database and migrate it
            // if(app()->isLocal()){
            //     DB::connection(config()->get('database.default'))->statement("CREATE DATABASE {$establishment->database}");
            // }
            // // DB::connection('shared')->statement("CREATE DATABASE {$establishment->database}");

            config(['database.connections.tenant.database' =>  $establishment->database]);
            config(['database.connections.tenant.username' =>  $establishment->database_username]);
            config(['database.connections.tenant.password' =>  $establishment->database_password]);

            DB::purge('tenant');
            DB::connection('tenant')->reconnect();

            DB::setDefaultConnection('tenant');
            \App::singleton('tenant', function() use($establishment){
                return $establishment;
            });

            // config()->set('database.connections.' . $tenant->identifier, $config);
            // config()->set('database.default', $tenant->identifier);

            \Artisan::call('migrate',
            array(
              '--path' => 'database/migrations',
              '--force' => true));
              \Artisan::call("db:seed", array(
                '--force' => true));

            \DB::statement("INSERT INTO `establishments`(`id`, `name`, `name_en`, `bio`, `email`, `phone1`, `phone2`, `whatstapp_number`, `website_link`, `address`, `currency`, `commercial_register_number`, `commercial_register_photo`, `commercial_register_end_at`, `tax_number`, `tax_certificate_image`, `license_number`, `license_image`, `evaluation_branch`, `evaluation_end_date`, `created_at`, `updated_at`, `data`, `domain`, `database`, `database_username`, `database_password`, `admin_id`)
         VALUES ($establishment->id,null,$establishment->name_en,null,$establishment->email,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,$establishment->domain,$establishment->database,$establishment->database_username,$establishment->database_password,$establishment->admin_id)");
            \DB::statement("INSERT INTO `options` (`id`, `title`, `face`, `insta`, `twitter`, `youtube`, `whats`, `phone`, `email`, `active`, `created_at`, `updated_at`, `title_en`, `mobile`, `website`, `about`, `address`, `commercial_number`, `commercial_date`, `license_number`, `license_date`, `image_commercial`, `image_license`, `stamp`, `logo`, `header`, `footer`, `background`, `cover`) VALUES (NULL, 'العقارات', 'facebook.com', 'instagram.com', 'twitter.com', 'youtube.com', 'Proident incididunt', '+1 (918) 107-8733', 'cexiho@mailinator.com', '1', '2021-02-20 15:18:03', '2022-10-20 01:34:40', 'Estate', 'Rem omnis possimus', 'https://www.fyzer.org.au', 'Pariatur Ut sapient', 'Enim error facilis c', '288', '1974-04-21 23:00:00', '209', '2006-02-03 23:00:00', '1666230348-6d00b2a3b7dd96642ca14a158a53655e.png', '1666230348-4511223.jpg', '1666230348-as.png', '1666230348-istockphoto-1215893553-170667a.jpg', '1666230348-istockphoto-1182601855-640x640.jpg', '1666230348-6d00b2a3b7dd96642ca14a158a53655e.png', '1666230348-6d00b2a3b7dd96642ca14a158a53655e.png', '1666230348-online.jpg')");


            // Artisan::call('migrate', ['--force' => true, '--database' => $establishment->database]);
            return redirect()->route('establishments.index')->with('done', 'تم اضافة منشأة جديدة بنجاح ....');
        } catch (\Exception $e) {
            // DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
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
    public function edit(string $id)
    {
        try {
            $establishment  = Establishment::findOrFail($id);
            return view('frontend.establishments.edit',compact('establishment'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $establishment  = Establishment::findOrFail($id);
            $validated = $request->validate([
                // 'admin_id'=>'required|string|exists:user,id|unique:establishments,admin_id',
                'name'=>'required|string',
                //unique except
                'email'=>['nullable','string','max:255',Rule::unique('users','email')->ignore($establishment->admin_id,'id')],
                // 'password'=>'string|min:6',
                'establishment_name'=>'required|string',
                'domain'=>['nullable','string','max:255',Rule::unique('establishments','domain')->ignore($establishment->id,'id')],
            ]);
            DB::beginTransaction();

            // $validated['password'] = $request->password ? Hash::make($request['password']) : Hash::make('123456789');
            // $validated['membership_level'] = 'admin';


            if($request->has('email'))
            {

                $user = User::findOrFail($establishment->admin_id);
                $user->update([
                    'name'=>$validated['name'],
                    'email'=>$validated['email'],
                ]);
            }


            $establishment->name = $validated['establishment_name'];
            $establishment->email = $validated['email'];
            $establishment->domain = $validated['domain'];
            $establishment->save();

            DB::Commit();
            return redirect()->route('establishments.index')->with('done', 'تم تعديل المنشأة جديدة بنجاح ....');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $establishment = Establishment::findOrFail($id);
            $admin = User::findOrFail($establishment->admin_id);
            $admin->delete();
            $establishment->delete();
            DB::commit();

            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }
}
