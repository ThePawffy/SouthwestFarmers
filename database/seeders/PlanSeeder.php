<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = array(
            array('subscriptionName' => 'Free', 'duration' => '7', 'offerPrice' => NULL, 'subscriptionPrice' => '0', 'status' => '1', 'features' => '{"features_0":["Lifetime Free  Update","1"],"features_1":["Permitted for 1 domain","1"],"features_2":["6 months technical support","1"],"features_3":["WhatsApp & Skype support","1"],"features_4":["Live support","1"],"features_5":["Free installation"],"features_6":["Free installation Cpanel"],"features_7":["Advance Remote Support"]}', 'created_at' => '2025-07-02 09:35:12', 'updated_at' => '2025-07-02 09:36:26'),
            array('subscriptionName' => 'Standard', 'duration' => '30', 'offerPrice' => NULL, 'subscriptionPrice' => '10', 'status' => '1', 'features' => '{"features_0":["Lifetime Free  Update","1"],"features_1":["Permitted for 1 domain","1"],"features_2":["6 months technical support","1"],"features_3":["WhatsApp & Skype support","1"],"features_4":["Live support","1"],"features_5":["Free installation","1"],"features_6":["Free installation Cpanel"],"features_7":["Advance Remote Support"]}', 'created_at' => '2025-07-02 09:35:12', 'updated_at' => '2025-07-02 09:37:06'),
            array('subscriptionName' => 'Premium', 'duration' => '180', 'offerPrice' => '50', 'subscriptionPrice' => '60', 'status' => '1', 'features' => '{"features_0":["Lifetime Free  Update","1"],"features_1":["Permitted for 1 domain","1"],"features_2":["6 months technical support","1"],"features_features_3":["WhatsApp & Skype support","1"],"features_4":["Live support","1"],"features_5":["Free installation","1"],"features_6":["Free installation Cpanel","1"],"features_7":["Advance Remote Support","1"]}', 'created_at' => '2025-07-02 09:35:12', 'updated_at' => '2025-07-02 09:37:19')
        );


        Plan::insert($plans);
    }
}
