<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::statement($this->dropView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    private function createView(): string
    {
        return <<<EOD
                  CREATE VIEW mapa_views AS
                        SELECT
                            arps.id,
                            arps.arp,
                            arps.pac,
                            arps.pe,
                            arps.vigenciaInicio,
                            arps.vigenciaFim,
                            (NOW() BETWEEN arps.vigenciaInicio AND arps.vigenciaFim) AS vigente,
                            arps.notas,
                            arps.created_at,
                            arps.updated_at,
                            objetos.sigma,
                            objetos.descricao as objeto,
                            items.valor,
                            coalesce((select sum(cotas.quantidade) from cotas where cotas.item_id = items.id), 0) as cota_total,
                            coalesce((select sum(cotas.empenho) from cotas where cotas.item_id = items.id), 0) as empenho_total,
                            setors.sigla,
                            setors.descricao as setor,
                            cotas.quantidade as quantidade_cota,
                            cotas.empenho as empenho_cota,
                            (cotas.quantidade - cotas.empenho) as saldo_cota
                        FROM arps
                            inner join items on (items.arp_id = arps.id)
                                inner join objetos on (objetos.id = items.objeto_id)
                            inner join cotas on (cotas.item_id = items.id)
                                inner join setors on (setors.id = cotas.setor_id)
                        order by arps.arp, objetos.descricao;
                EOD;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    private function dropView(): string
    {
        return <<<EOD

            DROP VIEW IF EXISTS `mapa_views`;
            EOD;
    }
};
