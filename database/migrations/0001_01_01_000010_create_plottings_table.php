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
        Schema::create('plottings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_datadiri')->nullable()->constrained('datadiris')->onDelete('cascade');
            $table->foreignId('id_kecamatan')->constrained('db_kecamatans')->onDelete('cascade');
            $table->foreignId('id_kelurahan')->constrained('db_kelurahans')->onDelete('cascade');
            $table->json('Rt')->nullable();
            $table->json('Rw')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plottings');
    }
};
