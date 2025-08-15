<?php
// 2025_08_08_000003_create_tb_jurusan_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tb_jurusan', function (Blueprint $table) {
            $table->id('id_jurusan');
            $table->unsignedBigInteger('id_sekolah');
            $table->string('nama_jurusan');
            $table->timestamps();

            $table->foreign('id_sekolah')->references('id_sekolah')->on('tb_sekolah');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_jurusan');
    }
};