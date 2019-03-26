<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTahunAjaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tahun_ajarans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tahun_ajaran');
            $table->string('tgl_pendaftaran')->nullable();
            $table->string('tgl_test')->nullable();
            $table->string('tgl_pengumuman')->nullable();
            $table->string('tgl_daftar_ulang')->nullable();
            $table->text('jadwal')->nullable();
            $table->text('brosur')->nullable();
            $table->enum('status', ['Show','Hidden'])->default('Hidden');
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
        Schema::dropIfExists('tahun_ajarans');
    }
}
