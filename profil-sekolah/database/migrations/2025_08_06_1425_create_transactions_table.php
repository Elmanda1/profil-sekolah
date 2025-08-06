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
        Schema::create('rekening_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('gurua')->onDelete('cascade');

            $table->enum('type', ['in', 'out']);
            $table->decimal('amount', 12, 2);   // Amount for the transaction
            $table->decimal('balance', 12, 2);  // Balance after transaction

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekening_transactions');

    }
};
