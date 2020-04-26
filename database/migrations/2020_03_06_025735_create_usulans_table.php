<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsulansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usulans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('usulan');
            $table->string('pod');
            $table->string('kelurahan');
            $table->string('volume');
            $table->string('satuan');
            $table->string('alamat');
            $table->string('alasan_usulan');
            $table->string('informasi_tambahan')->nullable();
            $table->string('output');
            $table->string('rt');
            $table->string('rw');
            $table->string('foto1');
            $table->string('foto2');
            $table->string('file1');
            $table->string('file2');
            $table->string('nama_pengusul');
            $table->string('hp_pengusul');
            $table->string('alamat_pengusul');
            $table->string('validasi')->nullable();
            $table->string('verifikasi')->nullable();
            $table->string('prioritas')->nullable();
            $table->boolean('loading_verifikasi');
            $table->boolean('loading_validasi');
            $table->boolean('loading_prioritas');
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
        Schema::dropIfExists('usulans');
    }
}
