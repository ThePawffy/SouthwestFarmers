<?php

namespace Modules\Landing\Database\Seeders;

use Modules\Landing\App\Models\Blog;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $blogs = array(
            array('id' => '1','user_id' => '1','title' => 'How Much Are Point of Sale Transaction Fees?','slug' => 'how-much-are-point-of-sale-transaction-fees','image' => 'uploads/25/02/1738652980-849.svg','status' => '1','descriptions' => 'Blessing welcomed ladyship she met humo ured sir breeding her. Six curiosity day assurance bed necessary','tags' => '["breeding","Point of Sale","Transaction"]','meta' => '{"title":"How Much Are Point of Sale Transaction Fees?","description":"Blessing welcomed ladyship she met humo ured sir breeding her. Six curiosity day assurance bed necessary"}','created_at' => '2025-02-04 16:08:34','updated_at' => '2025-02-04 13:09:40'),
            array('id' => '2','user_id' => '1','title' => 'What Are the 10 Risks of Inventory Transfer?','slug' => 'what-are-the-10-risks-of-inventory-transfer','image' => 'uploads/25/02/1738652951-760.svg','status' => '1','descriptions' => 'Blessing welcomed ladyship she met humo ured sir breeding her. Six curiosity day assurance bed necessary','tags' => '["Risks of Inventory"]','meta' => '{"title":"What Are the 10 Risks of Inventory Transfer?","description":"Blessing welcomed ladyship she met humo ured sir breeding her. Six curiosity day assurance bed necessary"}','created_at' => '2025-02-04 16:12:53','updated_at' => '2025-02-04 13:09:11'),
            array('id' => '3','user_id' => '1','title' => 'How Much Are Point of Sale Transaction Fees Abailabe?','slug' => 'how-much-are-point-of-sale-transaction-fees-abailabe','image' => 'uploads/25/02/1738653026-368.svg','status' => '1','descriptions' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been .','tags' => '["payslip", "payment", "Inventory"]','meta' => '{"title":"Provident quis nequ","description":"Lorem Ipsum is simply dummy"}','created_at' => '2025-01-08 10:57:31','updated_at' => '2025-02-04 13:10:26'),
            array('id' => '4','user_id' => '1','title' => 'How Much Are Point of Sale Transaction Fees Abailabes?','slug' => 'how-much-are-point-of-sale-transaction-fees-abailabes','image' => 'uploads/25/02/1738653011-327.svg','status' => '1','descriptions' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been .','tags' => '["Shop", "Grocery"]','meta' => '{"title":"Aut fugit officia v","description":"Suscipit non volupta"}','created_at' => '2025-01-08 10:59:01','updated_at' => '2025-02-04 13:10:11'),
            array('id' => '5','user_id' => '1','title' => 'How Much Are Point of Sale Transactions Fees Abailabe?','slug' => 'how-much-are-point-of-sale-transactions-fees-abailabe','image' => 'uploads/25/02/1738652995-87.svg','status' => '1','descriptions' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been .','tags' => '["Meat", "Pos Sale"]','meta' => '{"title":"Sunt et reprehenderi","description":"Soluta aliquip quam"}','created_at' => '2025-01-08 11:00:42','updated_at' => '2025-02-04 13:09:55')
          );

        Blog::insert($blogs);
    }
}
