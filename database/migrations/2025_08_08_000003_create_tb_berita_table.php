<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_berita', function (Blueprint $table) {
            $table->increments('id_berita');
            $table->string('judul', 200);
            $table->text('isi');
            $table->date('tanggal_berita');
            $table->string('penulis', 100)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_berita');
    }
};
