<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('students', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('name');
    //         $table->string('course');
    //         $table->string('email')->unique();
    //         $table->string('phone');
    //         $table->timestamps();
    //     });
    // }
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('course');
            $table->string('email')->unique();
            $table->string('phone');
            
            // Ajout de la colonne pour stocker les notes
            $table->json('grades')->nullable(); // Vous pouvez ajuster le type de données selon vos besoins

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
