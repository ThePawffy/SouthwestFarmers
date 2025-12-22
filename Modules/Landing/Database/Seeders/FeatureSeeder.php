<?php

namespace Modules\Landing\Database\Seeders;

use Modules\Landing\App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = array(
            array('id' => '1','title' => 'Much More...','bg_color' => '#BCEBD7','image' => 'modules/landing/uploads/25/01/1736313713-739.svg','status' => '1','created_at' => '2024-01-08 11:21:53','updated_at' => '2024-01-08 11:21:53'),
            array('id' => '2','title' => 'Reports','bg_color' => '#BCE9FF','image' => 'modules/landing/uploads/25/01/1736313674-209.svg','status' => '1','created_at' => '2024-01-09 11:21:14','updated_at' => '2024-01-09 11:21:14'),
            array('id' => '3','title' => 'Ledger','bg_color' => '#FFCADD','image' => 'modules/landing/uploads/25/01/1736313636-356.svg','status' => '1','created_at' => '2024-01-10 11:20:36','updated_at' => '2024-01-10 11:21:19'),
            array('id' => '4','title' => 'Stocks','bg_color' => '#F7C5FF','image' => 'modules/landing/uploads/25/01/1736313590-730.svg','status' => '1','created_at' => '2024-01-11 11:19:50','updated_at' => '2024-01-11 11:19:57'),
            array('id' => '5','title' => 'Due List','bg_color' => '#FFDDCC','image' => 'modules/landing/uploads/25/01/1736313555-821.svg','status' => '1','created_at' => '2024-01-12 11:19:15','updated_at' => '2024-01-12 11:19:15'),
            array('id' => '6','title' => 'Loss/Profit','bg_color' => '#D3C6F5','image' => 'modules/landing/uploads/25/01/1736313495-504.svg','status' => '1','created_at' => '2024-01-13 16:47:17','updated_at' => '2024-01-13 11:18:15'),
            array('id' => '7','title' => 'Purchase','bg_color' => '#BED8FF','image' => 'modules/landing/uploads/25/01/1736313460-140.svg','status' => '1','created_at' => '2024-01-14 16:47:42','updated_at' => '2024-01-14 11:17:40'),
            array('id' => '8','title' => 'Sale Return','bg_color' => '#FEE8C2','image' => 'modules/landing/uploads/25/01/1736313427-693.svg','status' => '1','created_at' => '2024-01-15 16:48:00','updated_at' => '2024-01-15 11:17:07'),
            array('id' => '9','title' => 'Items List','bg_color' => '#FFD5F1','image' => 'modules/landing/uploads/25/01/1736313397-975.svg','status' => '1','created_at' => '2024-01-16 16:48:20','updated_at' => '2024-01-16 11:16:37'),
            array('id' => '10','title' => 'Parties','bg_color' => '#C3CAFF','image' => 'modules/landing/uploads/25/01/1736313360-292.svg','status' => '1','created_at' => '2024-01-17 16:48:57','updated_at' => '2024-01-17 11:16:00'),
            array('id' => '11','title' => 'Sales List','bg_color' => '#FFDDCC','image' => 'modules/landing/uploads/25/01/1736313316-197.svg','status' => '1','created_at' => '2024-01-18 16:49:22','updated_at' => '2024-01-18 11:15:16'),
            array('id' => '12','title' => 'Pos Sales','bg_color' => '#BCEBD7','image' => 'modules/landing/uploads/25/01/1736313282-356.svg','status' => '1','created_at' => '2024-01-19 16:49:53','updated_at' => '2024-01-19 11:14:42'),
            array('id' => '13','title' => 'Clean code','bg_color' => '#BCE9FF','image' => 'modules/landing/uploads/25/01/1736313243-740.svg','status' => '1','created_at' => '2024-01-20 16:50:15','updated_at' => '2024-01-20 11:14:03'),
            array('id' => '14','title' => 'Regular bug fixing','bg_color' => '#FFCADD','image' => 'modules/landing/uploads/25/01/1736313209-229.svg','status' => '1','created_at' => '2024-01-21 16:50:37','updated_at' => '2024-01-21 11:13:29'),
            array('id' => '15','title' => '100+ Languages','bg_color' => '#F7C5FF','image' => 'modules/landing/uploads/25/01/1736313157-321.svg','status' => '1','created_at' => '2024-01-22 16:51:05','updated_at' => '2024-01-22 11:12:37'),
            array('id' => '16','title' => 'Lifetime updates','bg_color' => '#FFD8D8','image' => 'modules/landing/uploads/25/01/1736313104-246.svg','status' => '1','created_at' => '2024-01-23 16:51:36','updated_at' => '2024-01-23 11:11:44'),
            array('id' => '17','title' => 'Admin Dashboard','bg_color' => '#D3C6F5','image' => 'modules/landing/uploads/25/01/1736313022-945.svg','status' => '1','created_at' => '2024-01-24 11:10:22','updated_at' => '2024-01-24 11:10:22'),
            array('id' => '18','title' => 'iOS','bg_color' => '#FEE8C2','image' => 'modules/landing/uploads/25/01/1736312968-461.svg','status' => '1','created_at' => '2024-01-25 11:09:28','updated_at' => '2024-01-25 11:09:28'),
            array('id' => '19','title' => 'Android','bg_color' => '#BCEBD7','image' => 'modules/landing/uploads/25/01/1736312896-122.svg','status' => '1','created_at' => '2024-01-26 11:08:16','updated_at' => '2024-01-26 11:08:16'),
            array('id' => '20','title' => 'Flutter 3x','bg_color' => '#BED8FF','image' => 'modules/landing/uploads/25/01/1736312843-877.svg','status' => '1','created_at' => '2024-01-27 11:07:23','updated_at' => '2024-01-27 11:07:23'),

        );

        Feature::insert($features);
    }
}
