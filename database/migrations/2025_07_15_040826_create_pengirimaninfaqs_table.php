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
        Schema::create('pengirimaninfaqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_terima')->constrained('penerimaans')->onDelete('cascade');
            $table->string('nama_kecamatan')->nullable();
            $table->string('namaPengirim')->nullable();
            $table->string('namaPenerima')->nullable();
            $table->string('no_hp')->unique()->nullable();
            $table->date('tglKirim')->nullable();
            $table->text('pesan')->nullable();
            $table->text('file_kirim')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengirimaninfaqs');
    }
};
