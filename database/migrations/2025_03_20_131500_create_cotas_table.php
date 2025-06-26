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
        Schema::create('cotas', function (Blueprint $table) {
            $table->id();
            $table->integer('quantidade');
            $table->integer('empenho');
            $table->foreignId('setor_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('item_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cotas', function (Blueprint $table) {
            $table->dropForeign(['setor_id']);
            $table->dropForeign(['item_id']);
        });

        Schema::dropIfExists('cotas');
    }
};
