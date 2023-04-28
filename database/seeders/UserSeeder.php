<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run() {
        DB::table('users')->insert([
            'name' => 'Администратор',
            'email' => 'arman-aleqyan@mail.ru',
            'password' => \Hash::make('LJVkDM56GyH5dUc')
        ]);
    }
}
