<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'status' => '良好'
        ];
        DB::table('statuses')->insert($param);
        
        $param = [
            'status' => '目立った傷や汚れなし'
        ];
        DB::table('statuses')->insert($param);

        $param = [
            'status' => 'やや傷や汚れあり'
        ];
        DB::table('statuses')->insert($param);
        
        $param = [
            'status' => '状態が悪い'
        ];
        DB::table('statuses')->insert($param);
    }
}
