<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusTableSeeder extends Seeder
{

    static $labels = [
        'Aberto', 'Em andamento', 'Atrasado', 'Resolvido'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$labels as $label) {
            DB::table('status')->insert([
                'name' => $label,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
