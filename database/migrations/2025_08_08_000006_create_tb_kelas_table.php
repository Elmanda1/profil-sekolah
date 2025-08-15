<?php
// 2025_08_08_000006_create_tb_kelas_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tb_kelas', function (Blueprint $table) {
            $table->id('id_kelas');
            $table->unsignedBigInteger('id_sekolah');
            $table->unsignedBigInteger('id_jurusan')->nullable();
            $table->unsignedBigInteger('id_jenis_kelas')->nullable();
            $table->string('nama_kelas');
            $table->unsignedBigInteger('wali_kelas')->nullable();
            $table->timestamps();

            $table->foreign('id_sekolah')->references('id_sekolah')->on('tb_sekolah');
            $table->foreign('id_jurusan')->references('id_jurusan')->on('tb_jurusan');
            $table->foreign('id_jenis_kelas')->references('id_jenis_kelas')->on('tb_jenis_kelas');
            $table->foreign('wali_kelas')->references('id_guru')->on('tb_guru');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_kelas');
    }
};