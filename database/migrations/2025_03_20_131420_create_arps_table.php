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
        Schema::create('arps', function (Blueprint $table) {
            $table->id();
            $table->string('arp', 15)->unique(); # Ata de Registro de Preços
            $table->string('pac', 15); # Processo Administrativo de Compra
            $table->string('pe', 15); # Pregão Eletrônico
            $table->date('vigenciaInicio'); # Início da vigência
            $table->date('vigenciaFim'); # Fim da vigência
            $table->text('notas')->nullable(); # Objeto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arps');
    }
};
