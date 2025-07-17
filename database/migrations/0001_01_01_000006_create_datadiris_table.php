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
        Schema::create('datadiris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_setting')->constrained('settings')->onDelete('cascade');
            $table->string('nama_lengkap')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('tempat')->nullable();
            $table->date('tgllahir')->nullable();
            $table->text('foto')->nullable();
            $table->foreignId('id_kecamatan')->constrained('db_kecamatans')->onDelete('cascade');
            $table->foreignId('id_kelurahan')->constrained('db_kelurahans')->onDelete('cascade');
            $table->string('Rw')->nullable();
            $table->string('Rt')->nullable();
            $table->string('alamat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datadiris');
    }
};
