<?php

namespace Database\Seeders;

use App\Models\Kind;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KindSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kind::insert(
            [
                ['name' => 'ارض','active'=>1],
                ['name' => 'مباني','active'=>1]
            ]
        );
    }
}
