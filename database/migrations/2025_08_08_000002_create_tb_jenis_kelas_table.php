<?php
// 2025_08_08_000002_create_tb_jenis_kelas_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tb_jenis_kelas', function (Blueprint $table) {
            $table->id('id_jenis_kelas');
            $table->string('nama_jenis_kelas');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_jenis_kelas');
    }
};