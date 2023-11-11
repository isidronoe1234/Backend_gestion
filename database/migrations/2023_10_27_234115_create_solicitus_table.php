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
        Schema::create('solicitus', function (Blueprint $table) {
            $table->id();
            $table->string('NUE',10);
            $table->foreign('NUE')->references('NUE')->on('agremiados');
            $table->string('ruta_archivo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitus');
    }
};
