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
        Schema::create('db_kelurahan_petugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_petugas')->constrained('db_petugas')->onDelete('cascade');
            $table->foreignId('id_kelurahan')->constrained('db_kelurahans')->onDelete('cascade');
            $table->string('RW')->nullable();
            $table->string('RT')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('db_kelurahan_petugas');
    }
};
