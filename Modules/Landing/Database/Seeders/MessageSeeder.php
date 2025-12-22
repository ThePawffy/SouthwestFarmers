<?php

namespace Modules\Landing\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Landing\App\Models\Message;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $messages = array (
            array('name' => 'Shihab Uddin', 'phone' => '01367348921', 'email' => 'shihab@gmail.com', 'company_name' => 'Acnoo', 'message' => 'Hello Acnoo', 'created_at' => now(), 'updated_at' => now()),
            array('name' => 'Fohit Sharma', 'phone' => '01734785732', 'email' => 'rohit@gmail.com', 'company_name' => 'Facebook', 'message' => 'Hello Facebook', 'created_at' => now(), 'updated_at' => now()),
            array('name' => 'Noyon Shah', 'phone' => '01534794157', 'email' => 'noyon@gmail.com', 'company_name' => 'Youtube', 'message' => 'Hello Youtube', 'created_at' => now(), 'updated_at' => now()),
            array('name' => 'Shakil Mia', 'phone' => '01646104729', 'email' => 'shakil@gmail.com', 'company_name' => 'Twitter', 'message' => 'Hello Twitter', 'created_at' => now(), 'updated_at' => now()),
        );

        Message::insert($messages);
    }
}
