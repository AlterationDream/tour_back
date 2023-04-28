<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlacesSeeder extends Seeder
{
    public function run()
    {
        DB::table('places')->insert([
            [
                'id' => 1,
                'active' => true,
                'name' => 'Россия',
                'parent_id' => 0,
            ],[
                'id' => 2,
                'active' => true,
                'name' => 'Сочи',
                'parent_id' => 1,
            ],[
                'id' => 3,
                'active' => true,
                'name' => 'Абхазия',
                'parent_id' => 0,
            ]
        ]);
    }
}
