<?php

namespace Database\Seeders;

use App\Models\Party;
use Illuminate\Database\Seeder;

class PartySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parties = array (
            array('name' => 'Shihab Uddin', 'business_id' => '1', 'email' => 'shihab@gmail.com', 'type' => 'Dealer', 'phone' => '01354892146', 'due' => '700', 'address' => 'Dhaka', 'image' => 'uploads/25/05/1748430556-689.jpeg', 'status' => '1', 'created_at' => now(), 'updated_at' => now()),
            array('name' => 'Rohim Shah', 'business_id' => '1', 'email' => 'rohim@gmail.com', 'type' => 'Retailer', 'phone' => '01789238420', 'due' => '300', 'address' => 'Bogra', 'image' => 'uploads/25/05/1748430546-256.jpeg', 'status' => '1', 'created_at' => now(), 'updated_at' => now()),
            array('name' => 'Rita Rahman', 'business_id' => '1', 'email' => 'rita@gmail.com', 'type' => 'Wholesaler', 'phone' => '01678230921', 'due' => '200', 'address' => 'Khulna', 'image' => 'uploads/25/05/1748430530-747.jpeg', 'status' => '1', 'created_at' => now(), 'updated_at' => now()),
            array('name' => 'Raju Sekh', 'business_id' => '1', 'email' => 'raju@gmail.com', 'type' => 'Supplier', 'phone' => '01578239023', 'due' => '100', 'address' => 'Bhola', 'image' => 'uploads/25/05/1748430254-833.jpeg', 'status' => '1', 'created_at' => now(), 'updated_at' => now()),
            array('name' => 'Alok Uddin', 'business_id' => '1', 'email' => 'alok@gmail.com', 'type' => 'Supplier', 'phone' => '0183536434', 'due' => '250', 'address' => 'Barisal', 'image' => 'uploads/25/05/1748430265-243.jpeg', 'status' => '1', 'created_at' => now(), 'updated_at' => now()),
            array('name' => 'Fimi Hossein', 'business_id' => '1', 'email' => 'rimi@gmail.com', 'type' => 'Supplier', 'phone' => '01587238935', 'due' => '280', 'address' => 'Gabtoli', 'image' => 'uploads/25/05/1748430276-965.jpeg', 'status' => '1', 'created_at' => now(), 'updated_at' => now()),
        );

        Party::insert($parties);
    }
}
