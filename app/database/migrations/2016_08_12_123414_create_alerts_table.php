<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->bigIncrements('alert_id');
            $table->integer('sensor_id')->unsigned();
//            $table->foreign('sensor_id')->references('post_id')->on('posts')->onDelete('cascade');

            $table->integer('admin_id')->unsigned()->nullable();
//            $table->foreign('admin_id')->references('user_id')->on('users')->onDelete('SET NULL');

            $table->string('nome', 100);
            $table->tinyInteger('tipo_alerta');
            $table->text('indicador')->nullable();
            $table->text('condicao')->nullable();
            $table->string('horario', 100)->nullable();
            $table->boolean('envio_email')->default(1);
            $table->boolean('envio_sms')->default(0);
            $table->string('destinatarios', 500)->nullable();
            $table->boolean('status')->default(1);

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
