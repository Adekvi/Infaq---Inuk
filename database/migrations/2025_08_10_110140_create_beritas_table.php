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
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->string('tag')->nullable();
            $table->string('judul')->nullable();
            $table->text('ringkasan')->nullable();
            $table->text('foto1')->nullable();
            $table->string('motto1')->nullable();
            $table->string('judul1')->nullable();
            $table->string('ringkasan1')->nullable();
            $table->string('penulis')->nullable();
            $table->date('tgl_berita')->nullable();
            $table->text('foto2')->nullable();
            $table->string('status')->default('Aktif')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
