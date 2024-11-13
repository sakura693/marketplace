<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; /*追加*/

class ProductStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            ['item_id'=>1, 'status_id'=>'1'],
            ['item_id'=>2, 'status_id'=>'2'],
            ['item_id'=>3, 'status_id'=>'3'],
            ['item_id'=>4, 'status_id'=>'4'],
            ['item_id'=>5, 'status_id'=>'1'],
            ['item_id'=>6, 'status_id'=>'2'],
            ['item_id'=>7, 'status_id'=>'3'],
            ['item_id'=>8, 'status_id'=>'4'],
            ['item_id'=>9, 'status_id'=>'1'],
            ['item_id'=>10, 'status_id'=>'2']
        ];
        DB::table('product_statuses')->insert($param);
    }
}
