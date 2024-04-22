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
        Schema::create('pets', function (Blueprint $table) {
            /*
            $table->id();
            $table->timestamps();
            $table->string('nombre');
            $table->string('especie');
            $table->longText('notas');
            $table->foreignId('user_id')->constrained();
            */
            $table->id();
            $table->timestamps();
            $table->string('nombre');
            $table->date('fecha_nac');
            $table->string('especie');
            $table->enum('sexo', ['m', 'f']);
            $table->decimal('peso', 8, 2); // Assuming weight is stored as decimal with 8 digits total and 2 digits after the decimal point
            $table->text('observaciones')->nullable();
            $table->boolean('visible');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // Assuming 'users' table exists and 'id' column is the primary key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
