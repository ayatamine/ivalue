<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert(
            [
                ['name' => 'شقة','active'=>1,'created_at'=>Carbon::now()],
                ['name' => 'فيلا','active'=>1,'created_at'=>Carbon::now()],
                ['name' => 'عمارة','active'=>1,'created_at'=>Carbon::now()],
                ['name' => 'برج','active'=>1,'created_at'=>Carbon::now()],
                ['name' => 'مجمع','active'=>1,'created_at'=>Carbon::now()],
                ['name' => 'منتجع','active'=>1,'created_at'=>Carbon::now()],
                ['name' => 'مركز تجاري','active'=>1,'created_at'=>Carbon::now()],
                ['name' => 'مستودع','active'=>1,'created_at'=>Carbon::now()],
                ['name' => 'مصنع','active'=>1,'created_at'=>Carbon::now()],
                ['name' => 'مكتب','active'=>1,'created_at'=>Carbon::now()],
                ['name' => 'معرض','active'=>1,'created_at'=>Carbon::now()],
            ]
        );
    }
}
