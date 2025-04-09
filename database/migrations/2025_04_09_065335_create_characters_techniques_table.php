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
        Schema::create('characters_techniques', function (Blueprint $table) {
            $table->id();

            $table->foreignId('character_id')
            ->nullable()
            ->constrained('characters')
            ->onDelete('cascade');

            $table->foreignId('technique_id')
            ->nullable()
            ->constrained('techniques')
            ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters_techniques');
    }
};
