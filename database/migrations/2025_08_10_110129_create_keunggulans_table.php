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
        Schema::create('keunggulans', function (Blueprint $table) {
            $table->id();
            $table->string('tag')->nullable();
            $table->string('judul')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('kalimat1')->nullable();
            $table->string('motto1')->nullable();
            $table->text('ringkasan1')->nullable();
            $table->text('foto1')->nullable();
            $table->string('kalimat2')->nullable();
            $table->string('motto2')->nullable();
            $table->text('ringkasan2')->nullable();
            $table->text('foto2')->nullable();
            $table->string('kalimat3')->nullable();
            $table->string('motto3')->nullable();
            $table->text('ringkasan3')->nullable();
            $table->text('foto3')->nullable();
            $table->string('kalimat4')->nullable();
            $table->string('motto4')->nullable();
            $table->text('ringkasan4')->nullable();
            $table->text('foto4')->nullable();
            $table->string('status')->default('Aktif')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keunggulans');
    }
};
