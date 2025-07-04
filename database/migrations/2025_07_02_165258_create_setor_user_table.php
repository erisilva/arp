<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('setor_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setor_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('setor_user', function (Blueprint $table) {
            $table->dropForeign(['setor_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('setor_user');
    }
};
