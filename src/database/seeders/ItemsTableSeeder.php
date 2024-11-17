<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; /*追加*/

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '腕時計',
            'status_id' => '1',
            'user_id' => null,
            'price' => (int)str_replace(',', '', '15,0000'),
            'image' => 'storage/image/watch.jpg',
            'description' => 'スタイリッシュなデザインのメンズ腕時計'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => ' HDD',
            'status_id' => '2',
            'user_id' => null,
            'price' => (int)str_replace(',', '', '5,000'),
            'image' => 'storage/image/HDD.jpg',
            'description' => '高速で信頼性の高いハードディスク'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => '玉ねぎ３束',
            'status_id' => '3',
            'user_id' => null,
            'price' => (int)str_replace(',', '', '300'),
            'image' => 'storage/image/onion.jpg',
            'description' => '新鮮な玉ねぎ3束のセット'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => '革靴',
            'status_id' => '4',
            'user_id' => null,
            'price' => (int)str_replace(',', '', '4,000'),
            'image' => 'storage/image/leather shoes.jpg',
            'description' => 'クラシックなデザインの革靴'
        ];
        DB::table('items')->insert($param);
        
        $param = [
            'name' => 'ノートPC',
            'status_id' => '1',
            'user_id' => null,
            'price' => (int)str_replace(',', '', '45,000'),
            'image' => 'storage/image/PC.jpg',
            'description' => '高性能なノートパソコン'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'マイク',
            'status_id' => '2',
            'user_id' => null,
            'price' => (int)str_replace(',', '', '8,000'),
            'image' => 'storage/image/microphone.jpg',
            'description' => '高音質のレコーディング用マイク'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'ショルダーバッグ',
            'status_id' => '3',
            'user_id' => null,
            'price' => (int)str_replace(',', '', '3,500'),
            'image' => 'storage/image/shoulder bag.jpg',
            'description' => 'おしゃれなショルダーバッグ'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'タンブラー',
            'status_id' => '4',
            'user_id' => null,
            'price' => (int)str_replace(',', '', '500'),
            'image' => 'storage/image/tumbler.jpg',
            'description' => '使いやすいタンブラー'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'コーヒーミル',
            'status_id' => '1',
            'user_id' => null,
            'price' => (int)str_replace(',', '', '4,000'),
            'image' => 'storage/image/coffee mill.jpg',
            'description' => '手動のコーヒーミル'
        ];
        DB::table('items')->insert($param);
        
        $param = [
            'name' => 'メイクセット',
            'status_id' => '2',
            'user_id' => null,
            'price' => (int)str_replace(',', '', '2,500'),
            'image' => 'storage/image/make-up set.jpg',
            'description' => '便利なメイクアップセット'
        ];
        DB::table('items')->insert($param);
        
    }
}
