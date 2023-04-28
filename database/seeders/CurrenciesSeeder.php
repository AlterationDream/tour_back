<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrenciesSeeder extends Seeder
{
    public function run()
    {
        DB::table('currencies')->insert([
            [
                'id' => 1,
                'name' => 'Рубли',
                'short_name' => 'руб',
            ],
        ]);
    }
}
