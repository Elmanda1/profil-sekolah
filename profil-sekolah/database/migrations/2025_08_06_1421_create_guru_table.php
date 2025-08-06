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
        Schema::create('guru', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nip')->unique(); // Employee ID
            $table->string('subject'); // e.g., Math, English
            $table->string('phone');
            $table->string('photoUrl');
            $table->date('birth_date');
            $table->timestamps();

});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru');

    }
};
