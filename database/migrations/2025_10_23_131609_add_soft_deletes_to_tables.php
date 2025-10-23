<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tb_siswa', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('tb_guru', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('tb_akun', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_siswa', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('tb_guru', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('tb_akun', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
