<?php
// 2025_08_08_000005_create_tb_siswa_table.php
use Illuminate\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tb_siswa', function (Blueprint $table) {
            $table->id('id_siswa');
            $table->unsignedBigInteger('id_sekolah');
            $table->string('nisn', 50)->unique();
            $table->string('nama_siswa');
            $table->string('email')->unique()->nullable();
            $table->string('no_telp', 50)->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();

            $table->foreign('id_sekolah')->references('id_sekolah')->on('tb_sekolah');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_siswa');
    }
};