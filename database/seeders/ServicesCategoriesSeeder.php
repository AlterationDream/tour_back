<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesCategoriesSeeder extends Seeder
{
    public function run()
    {
        DB::table('services_categories')->insert([
        [
            'id' => 1,
            'active' => true,
            'name' => 'Проживание',
            'parent_id' => 0,
            'order' => 1,
            'shape' => '',
            'image' => ''
        ],[
            'id' => 2,
            'active' => true,
            'name' => 'Апартаменты',
            'parent_id' => 1,
            'order' => 1,
            'shape' => 'full',
            'image' => '/storage/services-categories-images/seed-sample/unsplash_q61fhpgLAgQ.png',
        ],[
            'id' => 3,
            'active' => true,
            'name' => 'Отели',
            'parent_id' => 1,
            'order' => 2,
            'shape' => 'half',
            'image' => '/storage/services-categories-images/seed-sample/unsplash_q61fhpgLAgQ2.png',
        ],[
            'id' => 4,
            'active' => true,
            'name' => 'Виллы, таунхаусы',
            'parent_id' => 1,
            'order' => 3,
            'shape' => 'half',
            'image' => '/storage/services-categories-images/seed-sample/unsplash_q61fhpgLAgQ3.png',
        ],[
            'id' => 5,
            'active' => true,
            'name' => 'Транспорт',
            'parent_id' => 0,
            'order' => 2,
            'shape' => '',
            'image' => ''
        ],[
            'id' => 6,
            'active' => true,
            'name' => 'Премиальные авто',
            'parent_id' => 5,
            'order' => 1,
            'shape' => 'full',
            'image' => '/storage/services-categories-images/seed-sample/unsplash_q61fhpgLAgQ4.png',
        ],[
            'id' => 7,
            'active' => true,
            'name' => 'Спорткары, редкие авто',
            'parent_id' => 5,
            'order' => 2,
            'shape' => 'small',
            'image' => '/storage/services-categories-images/seed-sample/unsplash_q61fhpgLAgQ5.png',
        ],[
            'id' => 8,
            'active' => true,
            'name' => 'Внедорожники',
            'parent_id' => 5,
            'order' => 3,
            'shape' => 'small',
            'image' => '/storage/services-categories-images/seed-sample/unsplash_q61fhpgLAgQ6.png',
        ],[
            'id' => 9,
            'active' => true,
            'name' => 'Мототехника',
            'parent_id' => 5,
            'order' => 4,
            'shape' => 'full',
            'image' => '/storage/services-categories-images/seed-sample/unsplash_q61fhpgLAgQ7.png',
        ]]);
    }
}
