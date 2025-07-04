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
                    CREATE TRIGGER trigger_after_insert_empenhos
                    AFTER INSERT ON empenhos
                    FOR EACH ROW
                    BEGIN
                        DECLARE soma_total_empenhado INT;

                        SELECT IFNULL(SUM(quantidade), 0) INTO soma_total_empenhado
                        FROM empenhos
                        WHERE cota_id = NEW.cota_id;

                        UPDATE cotas
                        SET empenho = soma_total_empenhado
                        WHERE id = NEW.cota_id;
                    END;
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

            DROP TRIGGER IF EXISTS trigger_after_insert_empenhos;
            EOD;
    }
};
