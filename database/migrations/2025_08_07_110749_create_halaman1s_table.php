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
        Schema::create('halaman1s', function (Blueprint $table) {
            $table->id();
            $table->string('judul1')->nullable();
            $table->string('kalimat1')->nullable();
            $table->string('ringkas1')->nullable();
            $table->text('foto1')->nullable();
            $table->string('judul2')->nullable();
            $table->string('kalimat2')->nullable();
            $table->string('ringkas2')->nullable();
            $table->text('foto2')->nullable();
            $table->string('status')->default('Nonaktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('halaman1s');
    }
};
