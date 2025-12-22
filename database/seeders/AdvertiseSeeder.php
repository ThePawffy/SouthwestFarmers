<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdvertiseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = array(
            array('name' => 'Free Shipping & Cashback Offer','imageUrl' => 'uploads/24/10/1729584140-184.svg','status' => '1','created_at' => now(),'updated_at' => now()),
            array('name' => 'Ramadan Supper Offer','imageUrl' => 'uploads/24/10/1729584235-936.svg','status' => '1','created_at' => now(),'updated_at' => now()),
          );

        Banner::insert($banners);
    }
}
