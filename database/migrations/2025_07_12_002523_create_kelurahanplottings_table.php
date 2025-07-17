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
        Schema::create('kelurahanplottings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plotting_id')->constrained('plottings')->onDelete('cascade');
            $table->foreignId('kelurahan_id')->constrained('db_kelurahans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelurahanplottings');
    }
};
