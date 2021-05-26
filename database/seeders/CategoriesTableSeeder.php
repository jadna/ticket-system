<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    static $labels = [
        'Tecnico', 'Suporte', 'Sistema', 'Outros'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$labels as $label) {
            DB::table('categories')->insert([
                'name' => $label,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
