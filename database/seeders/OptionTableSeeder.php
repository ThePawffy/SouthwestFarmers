<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class OptionTableSeeder extends Seeder
{
    public function run(): void
    {
        $options = array(
            array('key' => 'general','value' => '{"title":"Grocery Shop","app_link":"https://drive.usercontent.google.com/download?id=1c_o_nZugudqZDaotiik8Fuyue-HC9vpl&export=download&authuser=0","copy_right":"COPYRIGHT \\u00a9 2023 Acnoo, All rights Reserved","admin_footer_text":"Made By","admin_footer_link_text":"acnoo","admin_footer_link":"https:\\/\\/acnoo.com\\/","favicon":"uploads\\/24\\/10\\/1729699639-17.svg","admin_logo":"uploads\\/25\\/01\\/1738117805-766.svg","business_logo":"uploads\/25\/05\/1748427424-74.svg"}','status' => '1','created_at' => '2024-10-26 17:29:19','updated_at' => '2025-01-29 08:30:06'),
            array('key' => 'login-page','value' => '{"login_page_icon":"uploads\\/24\\/10\\/1729930200-411.svg","login_page_image":"uploads\\/24\\/10\\/1729930200-648.svg"}','status' => '1','created_at' => '2024-10-26 17:29:19','updated_at' => '2024-10-26 17:29:19'),
            array('key' => 'invoice_setting_1','value' => '"a4"','status' => '1','created_at' => now(),'updated_at' => now())
        );

        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        Option::insert($options);
    }
}
