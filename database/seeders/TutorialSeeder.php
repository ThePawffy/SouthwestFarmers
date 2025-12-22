<?php

namespace Database\Seeders;

use App\Models\Tutorial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TutorialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tutorials = array(
            array('title' => 'POS Sales Module Explained in 2 Minutes', 'thumbnail' => 'uploads/25/08/1754302714-820.svg', 'url' => 'https://www.youtube.com/', 'status' => '1', 'created_at' => '2025-08-04 15:12:21', 'updated_at' => '2025-08-04 16:18:34'),
            array('title' => 'How to Use Sales in POS Software?', 'thumbnail' => 'uploads/25/08/1754302821-103.svg', 'url' => 'https://www.youtube.com/', 'status' => '0', 'created_at' => '2025-08-04 15:12:21', 'updated_at' => '2025-08-04 16:20:21'),
            array('title' => 'How to Handle Daily Sales in Your POS System', 'thumbnail' => 'uploads/25/08/1754302943-291.svg', 'url' => 'https://www.youtube.com/', 'status' => '1', 'created_at' => '2025-08-04 15:12:21', 'updated_at' => '2025-08-04 16:22:23')
        );

        Tutorial::insert($tutorials);
    }
}
