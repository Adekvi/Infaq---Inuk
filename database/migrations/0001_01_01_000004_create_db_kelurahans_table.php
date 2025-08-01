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
        Schema::create('db_kelurahans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kecamatan')->constrained('db_kecamatans')->onDelete('cascade');
            $table->string('nama_kelurahan')->nullable();
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
        Schema::dropIfExists('db_kelurahans');
    }
};
