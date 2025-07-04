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
        Schema::create('empenho_user', function (Blueprint $table) {
            $table->foreignId('empenho_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->index(['empenho_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('empenho_user', function (Blueprint $table) {
            $table->dropForeign(['empenho_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('empenho_user');
    }
};
