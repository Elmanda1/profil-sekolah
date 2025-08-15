<?php
// 2025_08_08_000001_create_tb_sekolah_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tb_sekolah', function (Blueprint $table) {
            $table->id('id_sekolah');
            $table->string('nama_sekolah');
            $table->string('alamat')->nullable();
            $table->string('no_telp', 50)->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_sekolah');
    }
};