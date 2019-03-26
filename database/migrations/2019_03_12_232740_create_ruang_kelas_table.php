<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRuangKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ruang_kelas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_ta');
            $table->integer('id_kelas');
            $table->string('jurusan');
            $table->text('icon')->nullable();
            $table->string('ruang_kelas');
            $table->string('deskripsi')->nullable();
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
        Schema::dropIfExists('ruang_kelas');
    }
}
