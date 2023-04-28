<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InfoPageSeeder extends Seeder
{
    public function run()
    {
        DB::table('info_pages')->insert([
            [
                'id' => 1,
                'name' => 'О нас',
                'content' => '[]',
            ],[
                'id' => 2,
                'name' => 'VIP',
                'content' => '[]',
            ]
        ]);
    }
}
