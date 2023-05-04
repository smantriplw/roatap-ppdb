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
            $table->unsignedBigInteger('nisn'); // NISN
            $table->unsignedBigInteger('nik'); // NIK
            $table->string('name'); // Nama Siswa
            $table->string('mother_name'); // Nama Ibu
            $table->string('father_name'); // Nama Ayah
            $table->string('birthday'); // Tanggal Lahir
            $table->string('school'); // Asal Sekolah
            $table->integer('graduated_year'); // Tahun Lulus
            $table->bigInteger('phone'); // Nomor Telepon Siswa
            $table->string('email'); // Email Aktif
            $table->text('address'); // Alamat
            $table->enum('type', [
                'zonasi',
                'prestasi',
                'afirmasi',
                'mutasi',
            ]); // Jalur Pendaftaran
            $table->enum('gender', [
                'L',
                'P',
            ]); // Kelamin
            $table->enum('religion', [
                'islam',
                'kristen',
                'katolik',
                'hindu',
                'buddha',
                'konghucu',
            ]); // Agama
            $table->string('photo_path')->nullable(); // Lokasi nama foto
            $table->string('skhu_path')->nullable(); // Lokasi SKHU
            // $table->string('narkoba_path')->nullable(); // Lokasi Narkoba

            // ZONASI
            $table->string('kk_path')->nullable();

            // VERIFICATOR
            $table->unsignedBigInteger('verificator_id')->nullable();

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
