<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = array(
            array('unitName' => 'Box', 'business_id' => '1', 'status' => '1', 'created_at' => '2025-05-27 13:08:16', 'updated_at' => '2025-05-27 13:08:16'),
            array('unitName' => 'Pcs', 'business_id' => '1', 'status' => '1', 'created_at' => '2025-05-27 13:08:16', 'updated_at' => '2025-08-21 08:26:02'),
            array('unitName' => 'Kg', 'business_id' => '1', 'status' => '1', 'created_at' => '2025-05-27 13:08:16', 'updated_at' => '2025-08-21 08:25:48'),
            array('unitName' => 'Bottle', 'business_id' => '1', 'status' => '1', 'created_at' => '2025-05-27 13:08:16', 'updated_at' => '2025-05-27 13:08:16')
        );

        Unit::insert($units);
    }
}
