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
        \App\Models\Item::factory(50)->create();
        \App\Models\Review::factory(50)->create();
        $this->call([
            ItemImageSeeder::class,
            PurchaserSeeder::class,
            SellerSeeder::class,
            PointSeeder::class,
            CategorySeeder::class,
        ]);
    }
}