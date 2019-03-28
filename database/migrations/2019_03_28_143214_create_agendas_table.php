<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nomor_user')->nullable();
            $table->string('title');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('kegiatan', ['Akademik', 'Organisasi', 'Perseorangan']);
            $table->text('deskripsi')->nullable();
            $table->text('lampiran')->nullabel();
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
        Schema::dropIfExists('agendas');
    }
}
