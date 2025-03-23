<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class ArpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('arps')->insert([
            'arp' => 'ARP-0001',
            'pac' => 'PAC-0001',
            'pe' => 'PE-0001',
            'vigenciaInicio' => '2025-03-20',
            'vigenciaFim' => '2025-03-20',
            'notas' => 'Objeto da ARP-0001',
        ]);

        DB::table('arps')->insert([
            'arp' => 'ARP-0002',
            'pac' => 'PAC-0002',
            'pe' => 'PE-0002',
            'vigenciaInicio' => '2025-03-20',
            'vigenciaFim' => '2025-03-20',
            'notas' => 'Objeto da ARP-0002',
        ]);

        DB::table('arps')->insert([
            'arp' => 'ARP-0003',
            'pac' => 'PAC-0003',
            'pe' => 'PE-0003',
            'vigenciaInicio' => '2025-03-20',
            'vigenciaFim' => '2025-03-20',
            'notas' => 'Objeto da ARP-0003',
        ]);

        DB::table('arps')->insert([
            'arp' => 'ARP-0004',
            'pac' => 'PAC-0004',
            'pe' => 'PE-0004',
            'vigenciaInicio' => '2025-03-20',
            'vigenciaFim' => '2025-03-20',
            'notas' => 'Objeto da ARP-0004',
        ]);

        DB::table('arps')->insert([
            'arp' => 'ARP-0005',
            'pac' => 'PAC-0005',
            'pe' => 'PE-0005',
            'vigenciaInicio' => '2025-03-20',
            'vigenciaFim' => '2025-03-20',
            'notas' => 'Objeto da ARP-0005',
        ]);
    }
}
