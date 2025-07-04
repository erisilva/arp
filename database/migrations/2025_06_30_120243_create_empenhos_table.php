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
        Schema::create('empenhos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('cota_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->integer('quantidade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('empenhos', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['cota_id']);
        });
        Schema::dropIfExists('empenhos');
    }
};
