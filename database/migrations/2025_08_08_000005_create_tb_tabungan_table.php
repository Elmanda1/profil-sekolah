<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_tabungan', function (Blueprint $table) {
            $table->increments('id_tabungan');
            $table->unsignedInteger('id_siswa');
            $table->unsignedInteger('id_guru');
            $table->date('tanggal');
            $table->decimal('jumlah_tabungan', 12, 2);

            $table->foreign('id_siswa')->references('id_siswa')->on('tb_siswa');
            $table->foreign('id_guru')->references('id_guru')->on('tb_guru');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_tabungan');
    }
};
