<?php
// 2025_08_08_000004_create_tb_guru_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tb_guru', function (Blueprint $table) {
            $table->id('id_guru');
            $table->unsignedBigInteger('id_sekolah');
            $table->string('nama_guru');
            $table->enum('jenis_kelamin', ['L', 'P']);
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
        Schema::dropIfExists('tb_guru');
    }
};