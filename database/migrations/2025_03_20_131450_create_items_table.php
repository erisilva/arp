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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->decimal('valor', 10, 2);
            $table->foreignId('arp_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('objeto_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['arp_id']);
            $table->dropForeign(['objeto_id']);
        });

        Schema::dropIfExists('items');
    }
};
