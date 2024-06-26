<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTanyasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanyas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_soal');
            $table->text('pertanyaan');
            $table->string('gambar')->nullable();
            $table->string('jawaban')->nullable();
            $table->string('pilihan1')->nullable();
            $table->string('pilihan2')->nullable();
            $table->string('pilihan3')->nullable();
            $table->string('pilihan4')->nullable();
            $table->string('pilihan_benar')->nullable();
            $table->string('url_video')->nullable();
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
        Schema::dropIfExists('tanyas');
    }
}
