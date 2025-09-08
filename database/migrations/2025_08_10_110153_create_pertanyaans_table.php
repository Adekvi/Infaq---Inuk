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
        Schema::create('pertanyaans', function (Blueprint $table) {
            $table->id();
            $table->string('tag')->nullable();
            $table->string('judul')->nullable();
            $table->text('ringkasan')->nullable();
            $table->text('foto')->nullable();
            $table->string('pertanyaan1')->nullable();
            $table->text('jawaban1')->nullable();
            $table->string('pertanyaan2')->nullable();
            $table->text('jawaban2')->nullable();
            $table->string('pertanyaan3')->nullable();
            $table->text('jawaban3')->nullable();
            $table->string('pertanyaan4')->nullable();
            $table->text('jawaban4')->nullable();
            $table->string('pertanyaan5')->nullable();
            $table->text('jawaban5')->nullable();
            $table->string('status')->default('Aktif')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaans');
    }
};
