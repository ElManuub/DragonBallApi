<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * El método up se utiliza para agregar nuevas tablas, columnas o índices a la base de datos
     */
    public function up(): void
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age');
            $table->string('breed');
            $table->decimal('power', 8, 2);
            $table->enum('character_type', ['good', 'bad', 'unknow'])->default('unknow');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     * revertir las operaciones realizadas por el up método.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
