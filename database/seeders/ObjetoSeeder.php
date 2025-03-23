<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ObjetoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('objetos')->insert([
            'sigma' => '13.5.31',
            'descricao' => 'DEA (Desfibrilador Externo Automático)',
        ]);

        DB::table('objetos')->insert([
            'sigma' => '13.5.180',
            'descricao' => 'Detector Fetal',
        ]);

        DB::table('objetos')->insert([
            'sigma' => '65.40.12',
            'descricao' => 'Eletrocardiógrafo Digital 12 Canais',
        ]);

        DB::table('objetos')->insert([
            'sigma' => '060.009.9',
            'descricao' => 'Estetoscópio clínico duplo adulto',
        ]);

        DB::table('objetos')->insert([
            'sigma' => '060.009.7',
            'descricao' => 'Estetoscópio clínico duplo pediátrico',
        ]);

        DB::table('objetos')->insert([
            'sigma' => '6.3.1023',
            'descricao' => 'Foco/refletor clínico com pedestal sanfonado',
        ]);

        DB::table('objetos')->insert([
            'sigma' => '13.13.124',
            'descricao' => 'Otoscópio clínico',
        ]);

        DB::table('objetos')->insert([
            'sigma' => '060.009.12',
            'descricao' => 'Oxímetro de pulso portátil de mesa',
        ]);

        DB::table('objetos')->insert([
            'sigma' => '6.3.744',
            'descricao' => 'Oxímetro de pulso/dedo',
        ]);
    }
}
