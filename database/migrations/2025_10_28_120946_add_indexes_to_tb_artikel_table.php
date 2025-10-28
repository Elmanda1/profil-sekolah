tn<?php

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
        Schema::table('tb_artikel', function (Blueprint $table) {
            if (!Schema::hasIndex('tb_artikel', 'idx_artikel_judul')) {
                $table->index('judul', 'idx_artikel_judul');
            }
            if (!Schema::hasIndex('tb_artikel', 'idx_artikel_tanggal')) {
                $table->index('tanggal', 'idx_artikel_tanggal');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_artikel', function (Blueprint $table) {
            if (Schema::hasIndex('tb_artikel', 'idx_artikel_judul')) {
                $table->dropIndex('idx_artikel_judul');
            }
            if (Schema::hasIndex('tb_artikel', 'idx_artikel_tanggal')) {
                $table->dropIndex('idx_artikel_tanggal');
            }
        });
    }
};
