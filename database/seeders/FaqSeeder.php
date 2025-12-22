<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = array(
            array('question' => 'How do I add my store to the system?', 'answer' => 'You can request store addition from the Super Admin panel. Once approved, your branch will be activated with login access.', 'status' => '1', 'created_at' => '2025-08-04 14:57:53', 'updated_at' => '2025-08-04 14:57:53'),
            array('question' => 'Can I view sales and reports?', 'answer' => 'Yes, once your store is added, you can access detailed sales and performance reports from your dashboard.', 'status' => '1', 'created_at' => '2025-08-04 14:58:14', 'updated_at' => '2025-08-04 14:58:14'),
            array('question' => 'Do you sell fresh fruits and vegetables daily?', 'answer' => 'Yes, we ensure a daily supply of fresh fruits and vegetables, sourced directly from verified vendors.', 'status' => '1', 'created_at' => '2025-08-04 14:58:34', 'updated_at' => '2025-08-04 14:58:34'),
            array('question' => 'Can I add new products or request new items from Super Admin?', 'answer' => 'Yes, you can submit a request to the Super Admin for adding new products or items to your store inventory.', 'status' => '1', 'created_at' => '2025-08-04 14:58:51', 'updated_at' => '2025-08-04 14:58:51'),
            array('question' => 'How do I handle refunds or returns in the system?', 'answer' => 'You can process refunds or returns through the “Orders” section. Choose the relevant order and follow the return steps provided.', 'status' => '1', 'created_at' => '2025-08-04 14:59:13', 'updated_at' => '2025-08-04 14:59:13'),
            array('question' => 'How are online orders assigned to my branch?', 'answer' => 'Online orders are automatically assigned based on customer location and branch availability. You’ll receive notifications for each new order.', 'status' => '1', 'created_at' => '2025-08-04 14:59:31', 'updated_at' => '2025-08-04 14:59:31'),
            array('question' => 'Is there a way to see daily/weekly sales reports?', 'answer' => 'Yes, you can generate daily or weekly sales reports from the Reports tab on your dashboard.', 'status' => '1', 'created_at' => '2025-08-04 14:59:48', 'updated_at' => '2025-08-04 14:59:48')
        );

        Faq::insert($faqs);
    }
}
