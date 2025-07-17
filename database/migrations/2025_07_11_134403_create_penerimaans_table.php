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
        Schema::create('penerimaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_plot')->constrained('plottings')->onDelete('cascade');
            $table->date('tglSetor')->nullable();
            $table->string('namaBank')->nullable();
            $table->string('Rekening')->nullable();
            $table->integer('nominal')->nullable();
            $table->integer('jumlah')->nullable();
            $table->text('bukti_foto')->nullable();
            $table->string('Rt')->nullable();
            $table->string('Rw')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerimaans');
    }
};
