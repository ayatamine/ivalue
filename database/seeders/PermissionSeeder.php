<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Reset cached roles and permissions
         app()[PermissionRegistrar::class]->forgetCachedPermissions();
        // create permissions
        $create_estate = Permission::create(['name' => 'create estate']);
        $edit_estate = Permission::create(['name' => 'edit estate']);
        $delete_estate = Permission::create(['name' => 'delete estate']);
        $update_estate = Permission::create(['name' => 'update estate']);
        setPermissionsTeamId(1);

        // create roles and assign existing permissions
        $super_admin = Role::create(['name' => 'المشرف الرئيسي']);
        User::whereEmail('admin@gmail.com')->first()->assignRole($super_admin);

        $roles =[];
        $roles[] = Role::create(['name' => 'مدير المنشأة', 'team_id' => 1]);
        $roles[] = Role::create(['name' => 'المقيم', 'team_id' => 1]);
        $roles[] = Role::create(['name' => 'مدير التقييم', 'team_id' => 1]);
        $roles[] = Role::create(['name' => 'المعتمد', 'team_id' => 1]);
        $roles[] = Role::create(['name' => 'معتمد لقيمة', 'team_id' => 1]);
        $roles[] = Role::create(['name' => 'المراجع', 'team_id' => 1]);
        $roles[] = Role::create(['name' => 'المنسق', 'team_id' => 1]);
        $roles[] = Role::create(['name' => 'مدخل البيانات', 'team_id' => 1]);
        $roles[] = Role::create(['name' => 'المعاين', 'team_id' => 1]);

        foreach($roles as $role){
            $role->givePermissionTo([$create_estate ,$edit_estate,$delete_estate,$update_estate]);
        }


        // create demo users
        User::whereEmail('manager@gmail.com')->first()->assignRole($roles[0]);
        User::whereEmail('rater@gmail.com')->first()->assignRole($roles[1]);
        User::whereEmail('rater_manager@gmail.com')->first()->assignRole($roles[2]);
        User::whereEmail('approver@gmail.com')->first()->assignRole($roles[3]);
        User::whereEmail('qima_approver@gmail.com')->first()->assignRole($roles[4]);
        User::whereEmail('reviewer@gmail.com')->first()->assignRole($roles[5]);
        User::whereEmail('coordinator@gmail.com')->first()->assignRole($roles[6]);
        User::whereEmail('entre@gmail.com')->first()->assignRole($roles[7]);
        User::whereEmail('previewer@gmail.com')->first()->assignRole($roles[8]);
    }
}
