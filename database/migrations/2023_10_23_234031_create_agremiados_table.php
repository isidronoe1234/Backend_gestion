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
        Schema::create('agremiados', function (Blueprint $table) {
            $table->id();
            $table->string('a_paterno',45);
            $table->string('a_materno',45);
            $table->string('nombre',45);
            $table->string('sexo',45);
            $table->string('NUP');
            $table->string('NUE',10)->unique();
            $table->string('RFC')->unique();
            $table->string('NSS',11)->unique();
            $table->date('f_nacimiento');
            $table->string('telefono',10)->unique();
            $table->boolean('cuota');
            $table->boolean('status')->default(true);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agremiados');
    }
};
