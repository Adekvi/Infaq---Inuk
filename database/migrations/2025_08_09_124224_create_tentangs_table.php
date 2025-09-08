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
        Schema::create('tentangs', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable();
            $table->string('subjudul')->nullable();
            $table->text('ringkasan')->nullable();
            $table->string('motto1')->nullable();
            $table->text('icon1')->nullable();
            $table->string('ringkasan1')->nullable();
            $table->string('motto2')->nullable();
            $table->text('icon2')->nullable();
            $table->string('ringkasan2')->nullable();
            $table->string('subjudul1')->nullable();
            $table->string('no_hp')->nullable();
            $table->text('foto')->nullable();
            $table->string('status')->default('Aktif')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tentangs');
    }
};
