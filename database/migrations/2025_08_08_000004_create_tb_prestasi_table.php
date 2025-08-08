<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_prestasi', function (Blueprint $table) {
            $table->increments('id_prestasi');
            $table->unsignedInteger('id_siswa');
            $table->string('nama_prestasi', 100);
            $table->year('tahun')->nullable();

            $table->foreign('id_siswa')->references('id_siswa')->on('tb_siswa');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_prestasi');
    }
};
