<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritiesTableSeeder extends Seeder
{
    static $labels = [
        'Baixo', 'Normal', 'Alta','Urgente'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$labels as $label) {
            DB::table('priorities')->insert([
                'name' => $label
            ]);
        }
    }
}
