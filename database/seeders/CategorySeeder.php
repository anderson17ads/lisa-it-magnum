<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Tecnologia', 'created_at' => now()],
            ['name' => 'Beleza', 'created_at' => now()],
            ['name' => 'Saúde', 'created_at' => now()],
        ]);
    }
}
