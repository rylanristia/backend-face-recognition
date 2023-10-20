<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Rylanristia',
            'email' => 'rylanristia@gmail.com',
            'password' => Hash::make('valerieagatha_'),
            'token' => md5(date('Y-m-d H:i:s', time()) . 'xry&lAn' . date('i:s', time()))
        ]);
    }
}