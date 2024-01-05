<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusPelanggaranToSoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('soals', function (Blueprint $table) {
            //status_pelanggaran = 0 (pelanggaran tidak aktif)
            //status_pelanggaran = 1 (pelanggaran aktif)
            $table->integer('status_pelanggaran')->after('status_nilai')->default(0)->comment('0 = pelanggaran tidak aktif, 1 = pelanggaran aktif')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('soals', function (Blueprint $table) {
            $table->dropColumn('status_pelanggaran');
        });
    }
}
