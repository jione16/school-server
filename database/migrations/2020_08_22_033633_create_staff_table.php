<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffs', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->char('name');
            $table->char('gender');
            $table->char('nationality');
            $table->char('foreign_language_level');
            $table->char('genaral_knowledge_level');
            $table->date('date_of_birth');
            $table->char('place_of_birth');
            $table->char('address');
            $table->char('contact_number');
            $table->char('remark')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff');
    }
}
