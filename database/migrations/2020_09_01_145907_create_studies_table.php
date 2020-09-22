<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id');
            $table->integer('class_id');
            $table->boolean('is_active')->default(true);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            // $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            // $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('studies');
    }
}
