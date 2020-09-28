<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormationSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formation_sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('formation_id');
            $table->integer('session_number')->default(1);
            $table->date('date_debut');
            $table->date('date_end')->nullable();
            $table->integer('fee');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('teacher_id');
            $table->timestamps();

            $table->foreign('formation_id')->references('id')->on('formations');
            $table->foreign('teacher_id')->references('id')->on('teachers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formation_sessions');
    }
}
