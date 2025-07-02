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
        Schema::create('db_kecamatans', function (Blueprint $table) {
            $table->foreignId('id_kabupaten')->constrained('db_kabupatens')->onDelete('cascade');
            $table->id();
            $table->string('nama_kecamatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('db_kecamatans');
    }
};
