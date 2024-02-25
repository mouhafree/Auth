<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *  // {
    //     Schema::create('grades', function (Blueprint $table) {
    //         $table->id();
    //         $table->timestamps();
    //     });
    // }
    // public function up()
     */
    // public function up(): void
   
    // {
    //     Schema::create('grades', function (Blueprint $table) {
    //         $table->id();
    //         $table->unsignedBigInteger('student_id');
    //         $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
    //         $table->string('course');
    //         $table->integer('grade');
    //         $table->timestamps();
    //     });
    // }
    // database/migrations/xxxx_xx_xx_create_grades_table.php

    public function up(): void
    {
            Schema::create('grades', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('student_id')->unique();
                $table->float('note');
                $table->timestamps();

                // Foreign key relation with students table
                $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
