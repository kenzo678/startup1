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
        Schema::create('clinics', function (Blueprint $table) {
            /*
            $table->id();
            $table->timestamps();
            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->string('telf')->nullable();
            $table->string('email')->nullable();
            $table->string('direccion')->nullable();
            */
            $table->integer('id')->unique()->primary();
            $table->string('nombre');
            $table->string('telf')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('direccion')->nullable();
            $table->enum('tipo', ['clinica', 'consultorio']);
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('veterinaria');
    }
};
