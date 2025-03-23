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
            'name' => 'テストユーザー１',
            'email' => 'test1@gmail.com',
            'password' => Hash::make('password'),
            'image' => 'storage/image/girl.png',
            'postal_code' => null,
            'address' => null,
            'building' => null,
        ];
        DB::table('users')->insert($param);

        $param = [
            'id' => '2',
            'name' => 'テストユーザー２',
            'email' => 'test2@gmail.com',
            'password' => Hash::make('password'),
            'image' => 'storage/image/boy.png',
            'postal_code' => null,
            'address' => null,
            'building' => null,
        ];
        DB::table('users')->insert($param);

        $param = [
            'id' => '3',
            'name' => 'テストユーザー３',
            'email' => 'test3@gmail.com',
            'password' => Hash::make('password'),
            'image' => 'storage/image/sakura.jpg',
            'postal_code' => null,
            'address' => null,
            'building' => null,
        ];
        DB::table('users')->insert($param);
    }
}
