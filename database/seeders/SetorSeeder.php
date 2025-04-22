<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SetorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('setors')->insert([
            'sigla' => 'ALMOX',
            'descricao' => 'Almoxarifado',
        ]);

        DB::table('setors')->insert([
            'sigla' => 'ADMIN',
            'descricao' => 'Administração',
        ]);

        DB::table('setors')->insert([
            'sigla' => 'TI',
            'descricao' => 'Tecnologia da Informação',
        ]);

        DB::table('setors')->insert([
            'sigla' => 'JURID',
            'descricao' => 'Jurídico',
        ]);

        DB::table('setors')->insert([
            'sigla' => 'BUCAL',
            'descricao' => 'Saúde Bucal',
        ]);

        DB::table('setors')->insert([
            'sigla' => 'CIRUR',
            'descricao' => 'Cirurgia',
        ]);

        DB::table('setors')->insert([
            'sigla' => 'RH',
            'descricao' => 'Recursos Humanos',
        ]);

        DB::table('setors')->insert([
            'sigla' => 'DIR',
            'descricao' => 'Diretoria',
        ]);

    }
}
