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
            'id' => 1,
            'arp' => 'ARP-0001',
            'pac' => 'PAC-0001',
            'pe' => 'PE-0001',
            'vigenciaInicio' => '2025-05-20',
            'vigenciaFim' => '2025-08-18',
            'notas' => 'Objeto da ARP-0001',
        ]);


        DB::table('arps')->insert([
            'id' => 2,
            'arp' => 'ARP-0002',
            'pac' => 'PAC-0002',
            'pe' => 'PE-0002',
            'vigenciaInicio' => '2025-02-20',
            'vigenciaFim' => '2025-05-20',
            'notas' => 'Objeto da ARP-0002',
        ]);

        DB::table('arps')->insert([
            'id' => 3,
            'arp' => 'ARP-0003',
            'pac' => 'PAC-0003',
            'pe' => 'PE-0003',
            'vigenciaInicio' => '2025-03-20',
            'vigenciaFim' => '2025-03-20',
            'notas' => 'Objeto da ARP-0003',
        ]);

        DB::table('arps')->insert([
            'id' => 4,
            'arp' => 'ARP-0004',
            'pac' => 'PAC-0004',
            'pe' => 'PE-0004',
            'vigenciaInicio' => '2025-03-20',
            'vigenciaFim' => '2025-06-22',
            'notas' => 'Objeto da ARP-0004',
        ]);

        DB::table('arps')->insert([
            'id' => 5,
            'arp' => 'ARP-0005',
            'pac' => 'PAC-0005',
            'pe' => 'PE-0005',
            'vigenciaInicio' => '2025-03-20',
            'vigenciaFim' => '2025-03-20',
            'notas' => 'Objeto da ARP-0005',
        ]);

        DB::table('items')->insert([
            'arp_id' => 1,
            'objeto_id' => 1,
            'valor' => 13.99,
        ]);

        DB::table('items')->insert([
            'arp_id' => 2,
            'objeto_id' => 2,
            'valor' => 105.99,
        ]);

        DB::table('items')->insert([
            'arp_id' => 3,
            'objeto_id' => 3,
            'valor' => 12.49,
        ]);

        DB::table('items')->insert([
            'arp_id' => 4,
            'objeto_id' => 4,
            'valor' => 5.99,
        ]);

        DB::table('items')->insert([
            'arp_id' => 5,
            'objeto_id' => 5,
            'valor' => 1.99,
        ]);
    }
}
