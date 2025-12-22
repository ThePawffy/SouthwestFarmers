<?php

namespace Modules\Landing\Database\Seeders;

use Modules\Landing\App\Models\PosAppInterface;
use Illuminate\Database\Seeder;

class InterfaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pos_app_interfaces = array(
            array('id' => '1','image' => 'modules/landing/uploads/25/01/1736314901-192.svg','status' => '1','created_at' => '2024-04-16 16:18:51','updated_at' => '2025-01-08 11:41:41'),
            array('id' => '2','image' => 'modules/landing/uploads/25/01/1736314916-602.svg','status' => '1','created_at' => '2024-04-16 16:19:43','updated_at' => '2025-01-08 11:41:56'),
            array('id' => '3','image' => 'modules/landing/uploads/25/01/1736314883-308.svg','status' => '1','created_at' => '2024-04-18 14:56:07','updated_at' => '2025-01-08 11:41:23'),
            array('id' => '4','image' => 'modules/landing/uploads/25/01/1736314865-444.svg','status' => '1','created_at' => '2024-04-18 14:56:17','updated_at' => '2025-01-08 11:41:05'),
            array('id' => '5','image' => 'modules/landing/uploads/25/01/1736314848-484.svg','status' => '1','created_at' => '2024-04-18 14:56:25','updated_at' => '2025-01-08 11:40:48'),
            array('id' => '6','image' => 'modules/landing/uploads/25/01/1736314831-589.svg','status' => '1','created_at' => '2024-04-18 14:56:33','updated_at' => '2025-01-08 11:40:31'),
            array('id' => '7','image' => 'modules/landing/uploads/25/01/1736314813-926.png','status' => '1','created_at' => '2024-04-18 14:56:41','updated_at' => '2025-01-08 11:40:13'),
            array('id' => '8','image' => 'modules/landing/uploads/25/01/1736314794-731.svg','status' => '1','created_at' => '2024-04-18 14:56:49','updated_at' => '2025-01-08 11:39:54')
        );

        PosAppInterface::insert($pos_app_interfaces);
    }
}
