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
        $manage_users = Permission::create(['name' => 'manage users']);
        $view_kinds = Permission::create(['name' => 'view kinds']);
        $export_reports = Permission::create(['name' => 'export reports']);
        $view_categories = Permission::create(['name' => 'view categories']);

        setPermissionsTeamId(1);

        // create roles and assign existing permissions
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([$create_estate ,$edit_estate,$delete_estate,$update_estate,$view_categories,
        $export_reports,$view_kinds,$manage_users]);
        User::whereEmail('admin@gmail.com')->first()->assignRole($admin);

        $roles =[];
        $roles[] = Role::create(['name' => 'manager', 'team_id' => 1]);
        $roles[] = Role::create(['name' => 'rater', 'team_id' => 1]);
        $roles[] = Role::create(['name' => 'rater_manager', 'team_id' => 1]);
        $roles[] = Role::create(['name' => 'approver', 'team_id' => 1]);
        $roles[] = Role::create(['name' => 'value_approver', 'team_id' => 1]);
        $roles[] = Role::create(['name' => 'reviewer', 'team_id' => 1]);
        $roles[] = Role::create(['name' => 'coordinator', 'team_id' => 1]);
        $roles[] = Role::create(['name' => 'enter', 'team_id' => 1]);
        $roles[] = Role::create(['name' => 'previewer', 'team_id' => 1]);

        foreach($roles as $role){
            $role->givePermissionTo([$create_estate ,$edit_estate,$delete_estate,$update_estate]);
        }
        $user = User::create([
            'name'=>'super_admin',
            'email'=>'super_admin@gmail.com',
            'password'=>bcrypt('password'),
            'is_super_admin'=>true,
            'active'=>true,
            'membership_level'=>'admin'
        ]);
        $super_admin = Role::create(['name' => 'super-admin']);
        // $super_admin->givePermissionTo([$create_estate ,$edit_estate,$delete_estate,$update_estate,$view_categories,
        // $export_reports,$view_kinds,$manage_users]);

        $user->assignRole($super_admin);

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
