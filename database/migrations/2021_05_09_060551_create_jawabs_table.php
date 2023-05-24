<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // protected $fillable = ['id_user', 'id_soal', 'id_tanya', 'jawaban_benar', 'jawaban_user', 'status_jawab'];
        Schema::create('jawabs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_user');
            $table->integer('id_soal');
            $table->integer('id_tanya');
            $table->string('jawaban_benar')->nullable();
            $table->string('jawaban_user')->nullable();
            $table->string('status_jawab')->nullable();
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
        Schema::dropIfExists('jawabs');
    }
}
