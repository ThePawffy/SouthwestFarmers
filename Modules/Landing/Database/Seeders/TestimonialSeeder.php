<?php

namespace Modules\Landing\Database\Seeders;

use Modules\Landing\App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $testimonials = array(
            array('text' => 'Although this is well intentioned and the goal certainly is to reduce the quan the of these bot intentioned and','star' => '5','client_name' => 'Leslie Alexander','client_image' => 'uploads/25/02/1738637886-441.svg','work_at' => 'Ceo Google.inc','created_at' => now(),'updated_at' => now()),
            array('text' => 'Although this is well intentioned and the goal certainly is to reduce the quan the of these bot intentioned and','star' => '5','client_name' => 'Eleanor Pena','client_image' => 'uploads/25/02/1738637870-83.svg','work_at' => 'Ceo Google.inc','created_at' => now(),'updated_at' => now()),
            array('text' => 'Although this is well intentioned and the goal certainly is to reduce the quan the of these bot intentioned and','star' => '5','client_name' => 'Leslie Alexander','client_image' => 'uploads/25/02/1738638027-624.svg','work_at' => 'Ceo Google.inc','created_at' => now(),'updated_at' => now()),
            array('text' => 'Although this is well intentioned and the goal certainly is to reduce the quan the of these bot intentioned and','star' => '5','client_name' => 'Cody Fisher','client_image' => 'uploads/25/02/1738637860-650.svg','work_at' => 'Ceo Google.inc','created_at' => now(),'updated_at' => now()),
          );

        Testimonial::insert($testimonials);
    }
}
