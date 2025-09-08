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
        Schema::create('strukturs', function (Blueprint $table) {
            $table->id();
            $table->string('tag')->nullable();
            $table->string('judul')->nullable();
            $table->string('kalimat')->nullable();
            $table->text('logo')->nullable();
            $table->string('subjudul')->nullable();
            $table->string('alamat')->nullable();
            $table->string('no_telpon')->nullable();
            $table->string('email')->nullable();
            $table->string('alamatweb')->nullable();
            $table->string('judulsk')->nullable();
            $table->string('nomor')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('tentang')->nullable();
            $table->string('pengurus')->nullable();
            $table->string('judulpengurus')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('masapengurus')->nullable();
            $table->date('start_date')->nullable(); // Tanggal mulai masa jabatan
            $table->date('end_date')->nullable(); // Tanggal akhir masa jabatan
            $table->string('ketua')->nullable();
            $table->string('wakilketua1')->nullable();
            $table->string('wakilketua2')->nullable();
            $table->string('wakilketua3')->nullable();
            $table->string('sekretaris')->nullable();
            $table->string('wakilsekretaris')->nullable();
            $table->string('bendahara')->nullable();
            $table->string('wakilbendahara')->nullable();
            $table->text('penghimpunan')->nullable();
            $table->text('pendistribusian')->nullable();
            $table->text('keuangan')->nullable();
            $table->text('humas')->nullable();
            $table->string('status')->default('Aktif')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strukturs');
    }
};
