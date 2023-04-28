<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ServicesCategoriesSeeder::class,
            PlacesSeeder::class,
            CurrenciesSeeder::class,
            PriceUnitsSeeder::class,
            InfoPageSeeder::class,
        ]);
    }
}
