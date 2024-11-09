<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'price' => (int)str_replace(',', '', '15,0000'),
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            'description' => 'スタイリッシュなデザインのメンズ腕時計'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => ' HDD',
            'status_id' => '2',
            'price' => (int)str_replace(',', '', '5,000'),
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
            'description' => '高速で信頼性の高いハードディスク'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => '玉ねぎ３束',
            'status_id' => '3',
            'price' => (int)str_replace(',', '', '300'),
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            'description' => '新鮮な玉ねぎ3束のセット'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => '革靴',
            'status_id' => '12',
            'price' => (int)str_replace(',', '', '4,000'),
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
            'description' => 'クラシックなデザインの革靴'
        ];
        DB::table('items')->insert($param);
        
        $param = [
            'name' => 'ノートPC',
            'status_id' => '1',
            'price' => (int)str_replace(',', '', '45,000'),
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
            'description' => '高性能なノートパソコン'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'マイク',
            'status_id' => '10',
            'price' => (int)str_replace(',', '', '8,000'),
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
            'description' => '高音質のレコーディング用マイク'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'ショルダーバッグ',
            'status_id' => '11',
            'price' => (int)str_replace(',', '', '3,500'),
            'image' => '',
            'description' => 'おしゃれなショルダーバッグ'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'タンブラー',
            'status_id' => '12',
            'price' => (int)str_replace(',', '', '500'),
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            'description' => '使いやすいタンブラー'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'コーヒーミル',
            'status_id' => '1',
            'price' => (int)str_replace(',', '', '4,000'),
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
            'description' => '手動のコーヒーミル'
        ];
        DB::table('items')->insert($param);
        
        $param = [
            'name' => 'メイクセット',
            'status_id' => '10',
            'price' => (int)str_replace(',', '', '2,500'),
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
            'description' => '便利なメイクアップセット'
        ];
        DB::table('items')->insert($param);
        
    }
}
