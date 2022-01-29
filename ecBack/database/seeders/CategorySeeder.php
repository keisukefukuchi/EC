<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => '筆記用具'
            ],
            [
                'name' => '画材用具'
            ],
            [
                'name' => '紙製品'
            ],
            [
                'name' => '整理用品'
            ],
            [
                'name' => '机上用品'
            ],
            [
                'name' => '事務用品'
            ],
            [
                'name' => '製図用品'
            ],
            [
                'name' => 'その他'
            ],
        ]);
    }
}