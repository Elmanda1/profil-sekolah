<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * IMPORTANT: Jalankan ini HANYA jika tabel tb_siswa sudah ada
     * dan tidak punya indexes
     */
    public function up(): void
    {
        Schema::table('tb_siswa', function (Blueprint $table) {
            // Check if column exists before adding index
            try {
                // Basic indexes untuk search
                if (!$this->indexExists('tb_siswa', 'idx_siswa_nisn')) {
                    $table->index('nisn', 'idx_siswa_nisn');
                }
                
                if (!$this->indexExists('tb_siswa', 'idx_siswa_nama')) {
                    $table->index('nama_siswa', 'idx_siswa_nama');
                }
                
                if (!$this->indexExists('tb_siswa', 'idx_siswa_sekolah')) {
                    $table->index('id_sekolah', 'idx_siswa_sekolah');
                }
                
                // Status index (if column exists)
                if (Schema::hasColumn('tb_siswa', 'status') && !$this->indexExists('tb_siswa', 'idx_siswa_status')) {
                    $table->index('status', 'idx_siswa_status');
                }
                
                // Gender index (if column exists)
                if (Schema::hasColumn('tb_siswa', 'jenis_kelamin') && !$this->indexExists('tb_siswa', 'idx_siswa_gender')) {
                    $table->index('jenis_kelamin', 'idx_siswa_gender');
                }
                
                // Composite indexes untuk query optimization
                if (!$this->indexExists('tb_siswa', 'idx_siswa_sekolah_nama')) {
                    $table->index(['id_sekolah', 'nama_siswa'], 'idx_siswa_sekolah_nama');
                }
                
                // Only if status column exists
                if (Schema::hasColumn('tb_siswa', 'status') && !$this->indexExists('tb_siswa', 'idx_siswa_sekolah_status')) {
                    $table->index(['id_sekolah', 'status'], 'idx_siswa_sekolah_status');
                }
            } catch (\Exception $e) {
                // Ignore errors if index already exists
                echo "⚠️ Some indexes may already exist: " . $e->getMessage() . "\n";
            }
        });
        
        // Add indexes to tb_kelas_siswa if exists
        if (Schema::hasTable('tb_kelas_siswa')) {
            Schema::table('tb_kelas_siswa', function (Blueprint $table) {
                try {
                    if (!$this->indexExists('tb_kelas_siswa', 'idx_kelas_siswa_siswa')) {
                        $table->index('id_siswa', 'idx_kelas_siswa_siswa');
                    }
                    
                    if (!$this->indexExists('tb_kelas_siswa', 'idx_kelas_siswa_kelas')) {
                        $table->index('id_kelas', 'idx_kelas_siswa_kelas');
                    }
                    
                    if (!$this->indexExists('tb_kelas_siswa', 'idx_kelas_siswa_composite')) {
                        $table->index(['id_siswa', 'id_kelas'], 'idx_kelas_siswa_composite');
                    }
                } catch (\Exception $e) {
                    echo "⚠️ Some indexes may already exist on tb_kelas_siswa: " . $e->getMessage() . "\n";
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_siswa', function (Blueprint $table) {
            try {
                if ($this->indexExists('tb_siswa', 'idx_siswa_nisn')) {
                    $table->dropIndex('idx_siswa_nisn');
                }
                if ($this->indexExists('tb_siswa', 'idx_siswa_nama')) {
                    $table->dropIndex('idx_siswa_nama');
                }
                if ($this->indexExists('tb_siswa', 'idx_siswa_sekolah')) {
                    $table->dropIndex('idx_siswa_sekolah');
                }
                if ($this->indexExists('tb_siswa', 'idx_siswa_status')) {
                    $table->dropIndex('idx_siswa_status');
                }
                if ($this->indexExists('tb_siswa', 'idx_siswa_gender')) {
                    $table->dropIndex('idx_siswa_gender');
                }
                if ($this->indexExists('tb_siswa', 'idx_siswa_sekolah_nama')) {
                    $table->dropIndex('idx_siswa_sekolah_nama');
                }
                if ($this->indexExists('tb_siswa', 'idx_siswa_sekolah_status')) {
                    $table->dropIndex('idx_siswa_sekolah_status');
                }
            } catch (\Exception $e) {
                echo "⚠️ Error dropping indexes: " . $e->getMessage() . "\n";
            }
        });

        if (Schema::hasTable('tb_kelas_siswa')) {
            Schema::table('tb_kelas_siswa', function (Blueprint $table) {
                try {
                    if ($this->indexExists('tb_kelas_siswa', 'idx_kelas_siswa_siswa')) {
                        $table->dropIndex('idx_kelas_siswa_siswa');
                    }
                    if ($this->indexExists('tb_kelas_siswa', 'idx_kelas_siswa_kelas')) {
                        $table->dropIndex('idx_kelas_siswa_kelas');
                    }
                    if ($this->indexExists('tb_kelas_siswa', 'idx_kelas_siswa_composite')) {
                        $table->dropIndex('idx_kelas_siswa_composite');
                    }
                } catch (\Exception $e) {
                    echo "⚠️ Error dropping indexes from tb_kelas_siswa: " . $e->getMessage() . "\n";
                }
            });
        }
    }
    
    /**
     * Check if index exists
     */
    private function indexExists(string $table, string $index): bool
    {
        $connection = Schema::getConnection();
        $indexes = $connection->getDoctrineSchemaManager()
            ->listTableIndexes($table);
            
        return array_key_exists($index, $indexes);
    }
};