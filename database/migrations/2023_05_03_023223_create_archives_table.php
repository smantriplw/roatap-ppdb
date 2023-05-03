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
        Schema::create('archives', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // UMUM
            $table->integer('nisn'); // NISN
            $table->string('name'); // Nama Siswa
            $table->string('mother_name'); // Nama Ibu
            $table->string('father_name'); // Nama Ayah
            $table->date('birthday'); // Tanggal Lahir
            $table->string('school'); // Asal Sekolah
            $table->integer('graduated_year'); // Tahun Lulus
            $table->integer('phone'); // Nomor Telepon Siswa
            $table->string('email'); // Email Aktif
            $table->enum('type', [
                'zonasi',
                'prestasi',
                'afirmasi',
                'mutasi',
            ]); // Jalur Pendaftaran
            $table->string('photo_path'); // Lokasi nama foto
            $table->string('skhu_path'); // Lokasi SKHU

            // PRESTASI
            $table->string('certificate_path')->nullable(); // Lokasi foto sertifikat

            // AFIRMASI
            $table->string('kip_path')->nullable();

            // MUTASI
            $table->string('mutation_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
};
