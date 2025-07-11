<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;


class Acl extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // apaga todas as tabelas de relacionamento
        DB::table('role_user')->delete();
        DB::table('permission_role')->delete();

        // recebe os operadores principais principais do sistema
        // utilizo o termo operador em vez de usuário por esse
        // significar usuário do SUS, ou usuário do plano, em vez de pessoa ou cliente
        $administrador = User::where('email', '=', 'adm@mail.com')->get()->first();
        $gerente = User::where('email', '=', 'gerente@mail.com')->get()->first();
        $operador = User::where('email', '=', 'operador@mail.com')->get()->first();
        $leitor = User::where('email', '=', 'leitor@mail.com')->get()->first();
        $empenho = User::where('email', '=', 'empenho@mail.com')->get()->first();

        // recebi os perfis
        $administrador_perfil = Role::where('name', '=', 'admin')->get()->first();
        $gerente_perfil = Role::where('name', '=', 'gerente')->get()->first();
        $operador_perfil = Role::where('name', '=', 'operador')->get()->first();
        $leitor_perfil = Role::where('name', '=', 'leitor')->get()->first();
        $empenho_perfil = Role::where('name', '=', 'empenho')->get()->first();

        // salva os relacionamentos entre operador e perfil
        $administrador->roles()->attach($administrador_perfil);
        $gerente->roles()->attach($gerente_perfil);
        $operador->roles()->attach($operador_perfil);
        $leitor->roles()->attach($leitor_perfil);
        $empenho->roles()->attach($empenho_perfil);

        // recebi as permissoes
        // para operadores
        $user_index = Permission::where('name', '=', 'user-index')->get()->first();
        $user_create = Permission::where('name', '=', 'user-create')->get()->first();
        $user_edit = Permission::where('name', '=', 'user-edit')->get()->first();
        $user_delete = Permission::where('name', '=', 'user-delete')->get()->first();
        $user_show = Permission::where('name', '=', 'user-show')->get()->first();
        $user_export = Permission::where('name', '=', 'user-export')->get()->first();
        // para perfis
        $role_index = Permission::where('name', '=', 'role-index')->get()->first();
        $role_create = Permission::where('name', '=', 'role-create')->get()->first();
        $role_edit = Permission::where('name', '=', 'role-edit')->get()->first();
        $role_delete = Permission::where('name', '=', 'role-delete')->get()->first();
        $role_show = Permission::where('name', '=', 'role-show')->get()->first();
        $role_export = Permission::where('name', '=', 'role-export')->get()->first();
        // para permissões
        $permission_index = Permission::where('name', '=', 'permission-index')->get()->first();
        $permission_create = Permission::where('name', '=', 'permission-create')->get()->first();
        $permission_edit = Permission::where('name', '=', 'permission-edit')->get()->first();
        $permission_delete = Permission::where('name', '=', 'permission-delete')->get()->first();
        $permission_show = Permission::where('name', '=', 'permission-show')->get()->first();
        $permission_export = Permission::where('name', '=', 'permission-export')->get()->first();
        // para logs
        $log_index = Permission::where('name', '=', 'log-index')->get()->first();
        $log_show = Permission::where('name', '=', 'log-show')->get()->first();
        $log_export = Permission::where('name', '=', 'log-export')->get()->first();
        // para setor
        $setor_index = Permission::where('name', '=', 'setor-index')->get()->first();
        $setor_create = Permission::where('name', '=', 'setor-create')->get()->first();
        $setor_edit = Permission::where('name', '=', 'setor-edit')->get()->first();
        $setor_delete = Permission::where('name', '=', 'setor-delete')->get()->first();
        $setor_show = Permission::where('name', '=', 'setor-show')->get()->first();
        $setor_export = Permission::where('name', '=', 'setor-export')->get()->first();
        // para objeto
        $objeto_index = Permission::where('name', '=', 'objeto-index')->get()->first();
        $objeto_create = Permission::where('name', '=', 'objeto-create')->get()->first();
        $objeto_edit = Permission::where('name', '=', 'objeto-edit')->get()->first();
        $objeto_delete = Permission::where('name', '=', 'objeto-delete')->get()->first();
        $objeto_show = Permission::where('name', '=', 'objeto-show')->get()->first();
        $objeto_export = Permission::where('name', '=', 'objeto-export')->get()->first();
        // para arp
        $arp_index = Permission::where('name', '=', 'arp-index')->get()->first();
        $arp_create = Permission::where('name', '=', 'arp-create')->get()->first();
        $arp_edit = Permission::where('name', '=', 'arp-edit')->get()->first();
        $arp_delete = Permission::where('name', '=', 'arp-delete')->get()->first();
        $arp_show = Permission::where('name', '=', 'arp-show')->get()->first();
        $arp_export = Permission::where('name', '=', 'arp-export')->get()->first();
        // para item
        $item_index = Permission::where('name', '=', 'item-index')->get()->first();
        $item_create = Permission::where('name', '=', 'item-create')->get()->first();
        $item_edit = Permission::where('name', '=', 'item-edit')->get()->first();
        $item_delete = Permission::where('name', '=', 'item-delete')->get()->first();
        $item_show = Permission::where('name', '=', 'item-show')->get()->first();
        $item_export = Permission::where('name', '=', 'item-export')->get()->first();
        // para cota
        $cota_index = Permission::where('name', '=', 'cota-index')->get()->first();
        $cota_create = Permission::where('name', '=', 'cota-create')->get()->first();
        $cota_edit = Permission::where('name', '=', 'cota-edit')->get()->first();
        $cota_delete = Permission::where('name', '=', 'cota-delete')->get()->first();
        $cota_show = Permission::where('name', '=', 'cota-show')->get()->first();
        $cota_export = Permission::where('name', '=', 'cota-export')->get()->first();
        // para mapa
        $mapa_index = Permission::where('name', '=', 'mapa-index')->get()->first();
        $mapa_show = Permission::where('name', '=', 'mapa-show')->get()->first();
        $mapa_export = Permission::where('name', '=', 'mapa-export')->get()->first();
        // para import
        $import_index = Permission::where('name', '=', 'import-index')->get()->first();
        $import_create = Permission::where('name', '=', 'import-create')->get()->first();
        $import_show = Permission::where('name', '=', 'import-show')->get()->first();
        // para empenhos
        $empenho_index = Permission::where('name', '=', 'empenho-index')->get()->first();
        $empenho_create = Permission::where('name', '=', 'empenho-create')->get()->first();
        $empenho_edit = Permission::where('name', '=', 'empenho-edit')->get()->first();
        $empenho_delete = Permission::where('name', '=', 'empenho-delete')->get()->first();
        $empenho_show = Permission::where('name', '=', 'empenho-show')->get()->first();
        $empenho_export = Permission::where('name', '=', 'empenho-export')->get()->first();









        // salva os relacionamentos entre perfil e suas permissões

        // o administrador tem acesso total ao sistema, incluindo
        // configurações avançadas de desenvolvimento
        $administrador_perfil->permissions()->attach($user_index);
        $administrador_perfil->permissions()->attach($user_create);
        $administrador_perfil->permissions()->attach($user_edit);
        $administrador_perfil->permissions()->attach($user_delete);
        $administrador_perfil->permissions()->attach($user_show);
        $administrador_perfil->permissions()->attach($user_export);
        $administrador_perfil->permissions()->attach($role_index);
        $administrador_perfil->permissions()->attach($role_create);
        $administrador_perfil->permissions()->attach($role_edit);
        $administrador_perfil->permissions()->attach($role_delete);
        $administrador_perfil->permissions()->attach($role_show);
        $administrador_perfil->permissions()->attach($role_export);
        $administrador_perfil->permissions()->attach($permission_index);
        $administrador_perfil->permissions()->attach($permission_create);
        $administrador_perfil->permissions()->attach($permission_edit);
        $administrador_perfil->permissions()->attach($permission_delete);
        $administrador_perfil->permissions()->attach($permission_show);
        $administrador_perfil->permissions()->attach($permission_export);
        $administrador_perfil->permissions()->attach($log_index);
        $administrador_perfil->permissions()->attach($log_show);
        $administrador_perfil->permissions()->attach($log_export);
        $administrador_perfil->permissions()->attach($setor_index);
        $administrador_perfil->permissions()->attach($setor_create);
        $administrador_perfil->permissions()->attach($setor_edit);
        $administrador_perfil->permissions()->attach($setor_delete);
        $administrador_perfil->permissions()->attach($setor_show);
        $administrador_perfil->permissions()->attach($setor_export);
        $administrador_perfil->permissions()->attach($objeto_index);
        $administrador_perfil->permissions()->attach($objeto_create);
        $administrador_perfil->permissions()->attach($objeto_edit);
        $administrador_perfil->permissions()->attach($objeto_delete);
        $administrador_perfil->permissions()->attach($objeto_show);
        $administrador_perfil->permissions()->attach($objeto_export);
        $administrador_perfil->permissions()->attach($arp_index);
        $administrador_perfil->permissions()->attach($arp_create);
        $administrador_perfil->permissions()->attach($arp_edit);
        $administrador_perfil->permissions()->attach($arp_delete);
        $administrador_perfil->permissions()->attach($arp_show);
        $administrador_perfil->permissions()->attach($arp_export);
        $administrador_perfil->permissions()->attach($item_index);
        $administrador_perfil->permissions()->attach($item_create);
        $administrador_perfil->permissions()->attach($item_edit);
        $administrador_perfil->permissions()->attach($item_delete);
        $administrador_perfil->permissions()->attach($item_show);
        $administrador_perfil->permissions()->attach($item_export);
        $administrador_perfil->permissions()->attach($cota_index);
        $administrador_perfil->permissions()->attach($cota_create);
        $administrador_perfil->permissions()->attach($cota_edit);
        $administrador_perfil->permissions()->attach($cota_delete);
        $administrador_perfil->permissions()->attach($cota_show);
        $administrador_perfil->permissions()->attach($cota_export);
        $administrador_perfil->permissions()->attach($mapa_index);
        $administrador_perfil->permissions()->attach($mapa_show);
        $administrador_perfil->permissions()->attach($mapa_export);
        $administrador_perfil->permissions()->attach($import_index);
        $administrador_perfil->permissions()->attach($import_create);
        $administrador_perfil->permissions()->attach($import_show);
        #$administrador_perfil->permissions()->attach($empenho_index);
        $administrador_perfil->permissions()->attach($empenho_create);
        $administrador_perfil->permissions()->attach($empenho_edit);
        $administrador_perfil->permissions()->attach($empenho_delete);
        $administrador_perfil->permissions()->attach($empenho_show);
        $administrador_perfil->permissions()->attach($empenho_export);





        // o gerente (diretor) pode gerenciar os operadores do sistema
        $gerente_perfil->permissions()->attach($user_index);
        $gerente_perfil->permissions()->attach($user_create);
        $gerente_perfil->permissions()->attach($user_edit);
        $gerente_perfil->permissions()->attach($user_show);
        $gerente_perfil->permissions()->attach($user_export);
        $gerente_perfil->permissions()->attach($log_show);
        $gerente_perfil->permissions()->attach($log_show);
        $gerente_perfil->permissions()->attach($log_export);
        $gerente_perfil->permissions()->attach($setor_index);
        $gerente_perfil->permissions()->attach($setor_create);
        $gerente_perfil->permissions()->attach($setor_edit);
        $gerente_perfil->permissions()->attach($setor_show);
        $gerente_perfil->permissions()->attach($setor_export);
        $gerente_perfil->permissions()->attach($objeto_index);
        $gerente_perfil->permissions()->attach($objeto_create);
        $gerente_perfil->permissions()->attach($objeto_edit);
        $gerente_perfil->permissions()->attach($objeto_show);
        $gerente_perfil->permissions()->attach($objeto_export);
        $gerente_perfil->permissions()->attach($arp_index);
        $gerente_perfil->permissions()->attach($arp_create);
        $gerente_perfil->permissions()->attach($arp_edit);
        $gerente_perfil->permissions()->attach($arp_show);
        $gerente_perfil->permissions()->attach($arp_export);
        $gerente_perfil->permissions()->attach($item_index);
        $gerente_perfil->permissions()->attach($item_create);
        $gerente_perfil->permissions()->attach($item_edit);
        $gerente_perfil->permissions()->attach($item_show);
        $gerente_perfil->permissions()->attach($item_export);
        $gerente_perfil->permissions()->attach($cota_index);
        $gerente_perfil->permissions()->attach($cota_create);
        $gerente_perfil->permissions()->attach($cota_edit);
        $gerente_perfil->permissions()->attach($cota_show);
        $gerente_perfil->permissions()->attach($cota_export);
        $gerente_perfil->permissions()->attach($mapa_index);
        $gerente_perfil->permissions()->attach($mapa_show);
        $gerente_perfil->permissions()->attach($mapa_export);
        $gerente_perfil->permissions()->attach($import_index);
        $gerente_perfil->permissions()->attach($import_create);
        $gerente_perfil->permissions()->attach($import_show);
        #$gerente_perfil->permissions()->attach($empenho_index);
        $gerente_perfil->permissions()->attach($empenho_create);
        $gerente_perfil->permissions()->attach($empenho_edit);
        $gerente_perfil->permissions()->attach($empenho_delete);
        $gerente_perfil->permissions()->attach($empenho_show);
        $gerente_perfil->permissions()->attach($empenho_export);





        // o operador é o nível de operação do sistema não pode criar
        // outros operadores
        $operador_perfil->permissions()->attach($user_index);
        $operador_perfil->permissions()->attach($user_show);
        $operador_perfil->permissions()->attach($user_export);
        // $operador_perfil->permissions()->attach($log_show);
        // $operador_perfil->permissions()->attach($log_export);
        $operador_perfil->permissions()->attach($setor_index);
        $operador_perfil->permissions()->attach($setor_show);
        $operador_perfil->permissions()->attach($setor_export);
        $operador_perfil->permissions()->attach($objeto_index);
        $operador_perfil->permissions()->attach($objeto_show);
        $operador_perfil->permissions()->attach($objeto_export);
        $operador_perfil->permissions()->attach($arp_index);
        $operador_perfil->permissions()->attach($arp_create);
        $operador_perfil->permissions()->attach($arp_edit);
        $operador_perfil->permissions()->attach($arp_show);
        $operador_perfil->permissions()->attach($arp_export);
        $operador_perfil->permissions()->attach($item_index);
        $operador_perfil->permissions()->attach($item_create);
        $operador_perfil->permissions()->attach($item_edit);
        $operador_perfil->permissions()->attach($item_show);
        $operador_perfil->permissions()->attach($item_export);
        $operador_perfil->permissions()->attach($cota_index);
        $operador_perfil->permissions()->attach($cota_create);
        $operador_perfil->permissions()->attach($cota_edit);
        $operador_perfil->permissions()->attach($cota_show);
        $operador_perfil->permissions()->attach($cota_export);
        $operador_perfil->permissions()->attach($mapa_index);
        $operador_perfil->permissions()->attach($mapa_show);
        $operador_perfil->permissions()->attach($mapa_export);
        #$operador_perfil->permissions()->attach($empenho_index);
        $operador_perfil->permissions()->attach($empenho_create);
        $operador_perfil->permissions()->attach($empenho_edit);
        $operador_perfil->permissions()->attach($empenho_show);
        $operador_perfil->permissions()->attach($empenho_export);


        // leitura é um tipo de operador que só pode ler
        // os dados na tela
        $leitor_perfil->permissions()->attach($user_index);
        $leitor_perfil->permissions()->attach($user_show);
        $leitor_perfil->permissions()->attach($setor_index);
        $leitor_perfil->permissions()->attach($setor_show);
        $leitor_perfil->permissions()->attach($objeto_index);
        $leitor_perfil->permissions()->attach($objeto_show);
        $leitor_perfil->permissions()->attach($arp_index);
        $leitor_perfil->permissions()->attach($arp_show);
        $leitor_perfil->permissions()->attach($item_index);
        $leitor_perfil->permissions()->attach($item_show);
        $leitor_perfil->permissions()->attach($cota_index);
        $leitor_perfil->permissions()->attach($cota_show);
        $leitor_perfil->permissions()->attach($mapa_index);
        $leitor_perfil->permissions()->attach($mapa_show);
        #$leitor_perfil->permissions()->attach($empenho_index);
        $leitor_perfil->permissions()->attach($empenho_show);

        // o perfil empenho é igual ao leitor, porém poderá cadastrar empenhos
        $empenho_perfil->permissions()->attach($user_index);
        $empenho_perfil->permissions()->attach($user_show);
        $empenho_perfil->permissions()->attach($setor_index);
        $empenho_perfil->permissions()->attach($setor_show);
        $empenho_perfil->permissions()->attach($objeto_index);
        $empenho_perfil->permissions()->attach($objeto_show);
        $empenho_perfil->permissions()->attach($arp_index);
        $empenho_perfil->permissions()->attach($arp_show);
        $empenho_perfil->permissions()->attach($item_index);
        $empenho_perfil->permissions()->attach($item_show);
        $empenho_perfil->permissions()->attach($cota_index);
        $empenho_perfil->permissions()->attach($cota_show);
        $empenho_perfil->permissions()->attach($mapa_index);
        $empenho_perfil->permissions()->attach($mapa_show);
        #$empenho_perfil->permissions()->attach($empenho_index);
        $empenho_perfil->permissions()->attach($empenho_create);
        $empenho_perfil->permissions()->attach($empenho_edit);
        $empenho_perfil->permissions()->attach($empenho_show);
        $empenho_perfil->permissions()->attach($empenho_export);


        // atach all setors for $administrador
        if ($administrador) {
            foreach (\App\Models\Setor::all() as $setor) {
                $administrador->setors()->attach($setor->id);
            }
        }

        //atach all setors for $gerente
        if ($gerente) {
            foreach (\App\Models\Setor::all() as $setor) {
                $gerente->setors()->attach($setor->id);
            }
        }


    }
}
