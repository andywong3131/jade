<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert(
            [
                'name' => Str::random(20),
                'upc' => Str::random(10),
                'with_serial_number' => 1,
                'active' => 1
            ]
        );
    }
}
