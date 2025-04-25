<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // permission list for users table
        DB::table('permissions')->insert([
            'name' => 'user-index',
            'description' => 'Lista de operadores',
        ]);
        DB::table('permissions')->insert([
            'name' => 'user-create',
            'description' => 'Registrar novo operador',
        ]);
        DB::table('permissions')->insert([
            'name' => 'user-edit',
            'description' => 'Alterar dados do operador',
        ]);
        DB::table('permissions')->insert([
            'name' => 'user-delete',
            'description' => 'Excluir operador',
        ]);
        DB::table('permissions')->insert([
            'name' => 'user-show',
            'description' => 'Mostrar dados do operador',
        ]);
        DB::table('permissions')->insert([
            'name' => 'user-export',
            'description' => 'Exportação de dados dos operadores',
        ]);


        // permission list for roles table
        DB::table('permissions')->insert([
            'name' => 'role-index',
            'description' => 'Lista de perfis',
        ]);
        DB::table('permissions')->insert([
            'name' => 'role-create',
            'description' => 'Registrar novo perfil',
        ]);
        DB::table('permissions')->insert([
            'name' => 'role-edit',
            'description' => 'Alterar dados do perfil',
        ]);
        DB::table('permissions')->insert([
            'name' => 'role-delete',
            'description' => 'Excluir perfil',
        ]);
        DB::table('permissions')->insert([
            'name' => 'role-show',
            'description' => 'Alterar dados do perfil',
        ]);
        DB::table('permissions')->insert([
            'name' => 'role-export',
            'description' => 'Exportação de dados dos perfis',
        ]);

        // permission list for permissions table
        DB::table('permissions')->insert([
            'name' => 'permission-index',
            'description' => 'Lista de permissões',
        ]);
        DB::table('permissions')->insert([
            'name' => 'permission-create',
            'description' => 'Registrar nova permissão',
        ]);
        DB::table('permissions')->insert([
            'name' => 'permission-edit',
            'description' => 'Alterar dados da permissão',
        ]);
        DB::table('permissions')->insert([
            'name' => 'permission-delete',
            'description' => 'Excluir permissão',
        ]);
        DB::table('permissions')->insert([
            'name' => 'permission-show',
            'description' => 'Mostrar dados da permissão',
        ]);
        DB::table('permissions')->insert([
            'name' => 'permission-export',
            'description' => 'Exportação de dados das permissões',
        ]);

        // permission list for logs table
        DB::table('permissions')->insert([
            'name' => 'log-index',
            'description' => 'Lista de permissões',
        ]);
        DB::table('permissions')->insert([
            'name' => 'log-show',
            'description' => 'Mostrar dados da permissão',
        ]);
        DB::table('permissions')->insert([
            'name' => 'log-export',
            'description' => 'Exportação de dados das permissões',
        ]);


        // lista de permissões para a classe Setor
        DB::table('permissions')->insert([
            'name' => 'setor-index',
            'description' => 'Lista de setores',
        ]);
        DB::table('permissions')->insert([
            'name' => 'setor-create',
            'description' => 'Registrar novo setor',
        ]);
        DB::table('permissions')->insert([
            'name' => 'setor-edit',
            'description' => 'Alterar dados do setor',
        ]);
        DB::table('permissions')->insert([
            'name' => 'setor-delete',
            'description' => 'Excluir setor',
        ]);
        DB::table('permissions')->insert([
            'name' => 'setor-show',
            'description' => 'Mostrar dados do setor',
        ]);
        DB::table('permissions')->insert([
            'name' => 'setor-export',
            'description' => 'Exportação de dados dos setores',
        ]);

        // lista de permissões para a classe Objeto
        DB::table('permissions')->insert([
            'name' => 'objeto-index',
            'description' => 'Lista de objetos',
        ]);
        DB::table('permissions')->insert([
            'name' => 'objeto-create',
            'description' => 'Registrar novo objeto',
        ]);
        DB::table('permissions')->insert([
            'name' => 'objeto-edit',
            'description' => 'Alterar dados do objeto',
        ]);
        DB::table('permissions')->insert([
            'name' => 'objeto-delete',
            'description' => 'Excluir objeto',
        ]);
        DB::table('permissions')->insert([
            'name' => 'objeto-show',
            'description' => 'Mostrar dados do objeto',
        ]);
        DB::table('permissions')->insert([
            'name' => 'objeto-export',
            'description' => 'Exportação de dados dos objetos',
        ]);

        //lista de permissões para a classe Arp
        DB::table('permissions')->insert([
            'name' => 'arp-index',
            'description' => 'Lista de arps',
        ]);
        DB::table('permissions')->insert([
            'name' => 'arp-create',
            'description' => 'Registrar nova arp',
        ]);
        DB::table('permissions')->insert([
            'name' => 'arp-edit',
            'description' => 'Alterar dados da arp',
        ]);
        DB::table('permissions')->insert([
            'name' => 'arp-delete',
            'description' => 'Excluir arp',
        ]);
        DB::table('permissions')->insert([
            'name' => 'arp-show',
            'description' => 'Mostrar dados da arp',
        ]);
        DB::table('permissions')->insert([
            'name' => 'arp-export',
            'description' => 'Exportação de dados das arps',
        ]);

        // Permissões para a classe Item
        DB::table('permissions')->insert([
            'name' => 'item-index',
            'description' => 'Listagem dos objetos do arp',
        ]);
        DB::table('permissions')->insert([
            'name' => 'item-create',
            'description' => 'Registrar novo objeto ao arp',
        ]);
        DB::table('permissions')->insert([
            'name' => 'item-edit',
            'description' => 'Alterar dados do objeto no arp',
        ]);
        DB::table('permissions')->insert([
            'name' => 'item-delete',
            'description' => 'Excluir objeto de um arp',
        ]);
        DB::table('permissions')->insert([
            'name' => 'item-show',
            'description' => 'Mostrar dados de um objeto de um arp',
        ]);
        DB::table('permissions')->insert([
            'name' => 'item-export',
            'description' => 'Exportação de dados dos objetos de um arp',
        ]);

        // Permissões para a classe Cota
        DB::table('permissions')->insert([
            'name' => 'cota-index',
            'description' => 'Lista de cotas',
        ]);
        DB::table('permissions')->insert([
            'name' => 'cota-create',
            'description' => 'Registrar nova cota',
        ]);
        DB::table('permissions')->insert([
            'name' => 'cota-edit',
            'description' => 'Alterar dados da cota',
        ]);
        DB::table('permissions')->insert([
            'name' => 'cota-delete',
            'description' => 'Excluir cota',
        ]);
        DB::table('permissions')->insert([
            'name' => 'cota-show',
            'description' => 'Mostrar dados da cota',
        ]);
        DB::table('permissions')->insert([
            'name' => 'cota-export',
            'description' => 'Exportação de dados das cotas',
        ]);

    }
}
