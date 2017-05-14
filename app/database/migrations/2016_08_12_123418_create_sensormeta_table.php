<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSensormetaTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensormeta', function (Blueprint $table) {
            $table->bigIncrements('sensormeta_id');
            $table->integer('sensor_id')->unsigned();
//            $table->foreign('sensor_id')->references('post_id')->on('posts')->onDelete('cascade');

            $table->dateTime('last_activity')->nullable();
            $table->text('last_values')->nullable();
            $table->tinyInteger('alert_count')->default(0);
            $table->date('alert_day')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('alerts');
    }

}
