<?php
// 2025_08_08_000008_create_tb_prestasi_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tb_prestasi', function (Blueprint $table) {
            $table->id('id_prestasi');
            $table->unsignedBigInteger('id_sekolah');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal');
            $table->string('gambar')->nullable();
            $table->timestamps();

            $table->foreign('id_sekolah')->references('id_sekolah')->on('tb_sekolah');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_prestasi');
    }
};