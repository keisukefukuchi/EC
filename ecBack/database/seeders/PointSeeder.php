<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('points')->insert([
            [
                'purchaser_id' => 1,
                'point' => 100,
            ],
            [
                'purchaser_id' => 2,
                'point' => 120,
            ],
            [
                'purchaser_id' => 3,
                'point' => 140,
            ],
        ]);
    }
}