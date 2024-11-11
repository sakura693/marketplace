<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; /*追加*/

class ProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            ['item_id'=>1, 'category_id' =>1],

            ['item_id'=>2, 'category_id' =>2],

            ['item_id'=>3, 'category_id' =>10],

            ['item_id'=>4, 'category_id' =>1],
            ['item_id'=>4, 'category_id' =>5],

            ['item_id'=>5, 'category_id' =>2],
            ['item_id'=>5, 'category_id' =>8],

            ['item_id'=>6, 'category_id' =>2],

            ['item_id'=>7, 'category_id' =>1],
            ['item_id'=>7, 'category_id' =>4],

            ['item_id'=>8, 'category_id' =>10],

            ['item_id'=>9, 'category_id' =>2],
            ['item_id'=>9, 'category_id' =>10],

            ['item_id'=>10, 'category_id' =>4],
            ['item_id'=>10, 'category_id' =>6]
        ];
        DB::table('product_categories')->insert($param);
    }
}
