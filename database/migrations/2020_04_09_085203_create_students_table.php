<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('formation_session_id')->default(0);
            $table->string('fname');
            $table->string('lname');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('address')->nullable();
            $table->date('birth_date');
            $table->string('cin')->nullable();
            $table->string('sex');
            $table->string('photo')->nullable();
            $table->integer('machine_number')->nullable();
            $table->string('actual_job')->nullable();
            $table->string('family_situation')->nullable();
            $table->unsignedInteger('children_number')->default(0);
            $table->string('study_level')->nullable();
            $table->integer('school_fee_paid')->nullable()->default(0);
            $table->boolean('certified')->default(false);
            $table->date('certified_at')->nullable();
            $table->timestamps();

            $table->foreign('formation_session_id')->references('id')->on('formation_sessions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
