<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchaserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('purchasers')->insert([
            [
                'name' => '新堂持論',
                'email' => 'shin@shin.com',
                'gender' => '0',
                'birthday' => '1978-01-13',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'address' => '大阪府守口市佐太東町3-101-5',
                'image_path' => '/storage/sample.jpg',
            ],
            [
                'name' => '持田栄光',
                'email' => 'motida@motida.com',
                'gender' => '0',
                'birthday' => '1998-12-10',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'address' => '京都府京都市伏見区淀水垂町509-16',
                'image_path' => '/storage/sample.jpg',
            ],
            [
                'name' => '留酢雪上',
                'email' => 'tome@tome.com',
                'gender' => '0',
                'birthday' => '1965-07-1',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'address' => '愛知県名古屋市北区金田町4-721-1',
                'image_path' => '/storage/sample.jpg',
            ],
        ]);
    }
}