<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'id' => '1',
            'name' => 'はなこ',
            'email' => 'hanako@test.com',
            'password' => Hash::make('password'),
            'image' => 'storage/image/girl.png',
            'postal_code' => null,
            'address' => null,
            'building' => null,
        ];
        DB::table('users')->insert($param);

        $param = [
            'id' => '2',
            'name' => 'たろう',
            'email' => 'taro@test.com',
            'password' => Hash::make('password'),
            'image' => 'storage/image/boy.png',
            'postal_code' => null,
            'address' => null,
            'building' => null,
        ];
        DB::table('users')->insert($param);

        $param = [
            'id' => '3',
            'name' => 'さくら',
            'email' => 'sakura@test.com',
            'password' => Hash::make('password'),
            'image' => 'storage/image/sakura.jpg',
            'postal_code' => null,
            'address' => null,
            'building' => null,
        ];
        DB::table('users')->insert($param);
    }
}
