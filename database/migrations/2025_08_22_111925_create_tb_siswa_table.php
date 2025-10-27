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
        Schema::create('tb_siswa', function (Blueprint $table) {
            // Primary Key - Check what type tb_sekolah uses
            $table->integer('id_siswa', true); // Auto-increment integer to match other tables
            
            // Foreign Key - MUST match tb_sekolah.id_sekolah type!
            $table->integer('id_sekolah')->index('idx_siswa_sekolah');
            
            // Student Information
            $table->string('nisn', 50)->unique()->comment('Nomor Induk Siswa Nasional');
            $table->string('nama_siswa', 255);
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->date('tanggal_lahir')->nullable()->comment('Format: YYYY-MM-DD');
            $table->string('tempat_lahir', 100)->nullable();
            
            // Contact Information
            $table->string('email', 255)->nullable()->unique();
            $table->string('no_telp', 20)->nullable();
            $table->text('alamat')->nullable();
            
            // Additional Information
            $table->string('foto', 255)->nullable()->comment('Filename only, not full path');
            $table->enum('status', ['aktif', 'non-aktif', 'lulus', 'pindah'])->default('aktif');
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for Performance (IMPORTANT!)
            $table->index('nisn', 'idx_siswa_nisn');
            $table->index('nama_siswa', 'idx_siswa_nama');
            $table->index('status', 'idx_siswa_status');
            $table->index('jenis_kelamin', 'idx_siswa_gender');
            
            // Composite indexes for common queries
            $table->index(['id_sekolah', 'nama_siswa'], 'idx_siswa_sekolah_nama');
            $table->index(['id_sekolah', 'status'], 'idx_siswa_sekolah_status');
        });
        
        // Add foreign key AFTER table is created
        // This is more reliable than doing it in the same block
        Schema::table('tb_siswa', function (Blueprint $table) {
            $table->foreign('id_sekolah', 'fk_siswa_sekolah')
                  ->references('id_sekolah')
                  ->on('tb_sekolah')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
        
        // Add comment to table
        DB::statement("ALTER TABLE tb_siswa COMMENT = 'Tabel data siswa/pelajar'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_siswa');
    }
};