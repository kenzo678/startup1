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
        Schema::create('pet_tratamientos', function (Blueprint $table) {
            /*
            $table->id();
            $table->timestamps();
            $table->foreignId('pet_id')->constrained();
            $table->string('titulo');
            $table->longText('desc');
            */
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('pet_id');
            $table->unsignedBigInteger('veterinarian_id');
            $table->string('title');
            $table->text('description');
            $table->date('treatment_date');
            $table->date('checkup_date');
            // Define foreign key constraints
            $table->foreign('pet_id')->references('id')->on('pets')->onDelete('cascade');
            $table->foreign('veterinarian_id')->references('id')->on('vets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_tratamientos');
    }
};
