<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceUnitsSeeder extends Seeder
{
    public function run()
    {
        DB::table('price_units')->insert([
            [
                'id' => 1,
                'name' => '/час',
            ],[
                'id' => 2,
                'name' => '/мес',
            ],
        ]);
    }
}
