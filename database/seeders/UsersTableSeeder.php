<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
        /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'ABSX Suporte',
            'email' => 'absx.suporte@mailinator.com',
            'password' => bcrypt('123456'),
            'is_admin' => 1,
            'active' => 1,
        ]);
        DB::table('users')->insert([
            'name' => 'Felipe',
            'email' => 'felipe.absx@mailinator.com',
            'password' => bcrypt('123456'),
            'is_admin' => 0,
            'active' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'Marcos',
            'email' => 'marcos.absx@mailinator.com',
            'password' => bcrypt('123456'),
            'is_admin' => 0,
            'active' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'João',
            'email' => 'joao.absx@mailinator.com',
            'password' => bcrypt('123456'),
            'is_admin' => 0,
            'active' => 1,
        ]);
            
    }
}
