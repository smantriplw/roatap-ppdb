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
        Schema::create('daftar_ulang', function (Blueprint $table) {
            $table->id();
            $table->string('no_kk');
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->string('no_kip')->nullable();

            $table->integer('height_body');
            $table->integer('width_body');
            $table->integer('head_circumference');
            $table->integer('school_distance');
            $table->integer('school_est_time'); // estimasi waktu tempuh ke sklh
            $table->integer('siblings');
            $table->integer('siblings_position'); // NB: 0 < siblings_position <= siblings
            
            $table->enum('transportation', [
                'Jalan Kaki', 'Angkutan umum/bus/pete-pete', 'Mobil/bus antar jemput',
                'Kereta Api', 'Ojek', 'Andong/bendi/sado/dokar/delman/becak',
                'Perahu penyeberangan/rakit/getek', 'Kuda', 'Sepeda',
            ]); // based on Dapodik's data
            $table->enum('live', [
                'Bersama orang tua', 'Wali', 'Kost', 'Asrama',
                'Panti Asuhan', 'Pesantren', 'Lainnya',
            ]); // based on Dapodik's data
            
            // Father's data
            $table->string('nik_father');
            $table->integer('birth_father');
            $table->enum('last_edu_father', [
                'D1', 'D2', 'D3', 'D4',
                'Informal', 'Lainnya', 'Non formal',
                'Paket A', 'Paket B', 'Paket C', 'PAUD',
                'Putus SD', 'S1', 'S2', 'S2 Terapan', 'S3',
                'SD', 'SMP', 'Sp-1','Sp-2', 'Tidak sekolah', 'TK',
            ]); // based on Dapodik's data
            $table->enum('job_father', [
                'Tidak bekerja', 'Nelayan', 'Petani', 'Peternak',
                'PNS/TNI/Polri', 'Karyawan Swasta', 'Pedagang Kecil', 'Pedagang Besar',
                'Wiraswasta', 'Wirausaha', 'Buruh', 'Pensiunan', 'Tenaga Kerja Indonesia',
                'Karyawan BUMN', 'Tidak dapat diterapkan', 'Sudah Meninggal', 'Lainnya',
            ]); // based on Dapodik's data
            $table->enum('salary_father', [
                '< Rp.500.000', 'Rp.500.000 - Rp.999.999', 'Rp.1.000.000 - Rp.1.999.999',
                'Rp.2.000.000 - Rp.4.999.999', 'Rp.5.000.000 - Rp.20.000.000',
                '> Rp.20.000.000', 'Tidak Berpenghasilan',
            ]); // based on Dapodik's data

            // Mother's data
            $table->string('nik_mother');
            $table->integer('birth_mother');
            $table->enum('last_edu_mother', [
                'D1', 'D2', 'D3', 'D4',
                'Informal', 'Lainnya', 'Non formal',
                'Paket A', 'Paket B', 'Paket C', 'PAUD',
                'Putus SD', 'S1', 'S2', 'S2 Terapan', 'S3',
                'SD', 'SMP', 'Sp-1','Sp-2', 'Tidak sekolah', 'TK',
            ]); // based on Dapodik's data
            $table->enum('job_mother', [
                'Tidak bekerja', 'Nelayan', 'Petani', 'Peternak',
                'PNS/TNI/Polri', 'Karyawan Swasta', 'Pedagang Kecil', 'Pedagang Besar',
                'Wiraswasta', 'Wirausaha', 'Buruh', 'Pensiunan', 'Tenaga Kerja Indonesia',
                'Karyawan BUMN', 'Tidak dapat diterapkan', 'Sudah Meninggal', 'Lainnya',
            ]); // based on Dapodik's data
            $table->enum('salary_mother', [
                '< Rp.500.000', 'Rp.500.000 - Rp.999.999', 'Rp.1.000.000 - Rp.1.999.999',
                'Rp.2.000.000 - Rp.4.999.999', 'Rp.5.000.000 - Rp.20.000.000',
                '> Rp.20.000.000', 'Tidak Berpenghasilan',
            ]); // based on Dapodik's data

            // Wali
            $table->string('nik_wali')->nullable();
            $table->integer('birth_wali')->nullable();
            $table->enum('last_edu_wali', [
                'D1', 'D2', 'D3', 'D4',
                'Informal', 'Lainnya', 'Non formal',
                'Paket A', 'Paket B', 'Paket C', 'PAUD',
                'Putus SD', 'S1', 'S2', 'S2 Terapan', 'S3',
                'SD', 'SMP', 'Sp-1','Sp-2', 'Tidak sekolah', 'TK',
            ])->nullable(); // based on Dapodik's data
            $table->enum('job_wali', [
                'Tidak bekerja', 'Nelayan', 'Petani', 'Peternak',
                'PNS/TNI/Polri', 'Karyawan Swasta', 'Pedagang Kecil', 'Pedagang Besar',
                'Wiraswasta', 'Wirausaha', 'Buruh', 'Pensiunan', 'Tenaga Kerja Indonesia',
                'Karyawan BUMN', 'Tidak dapat diterapkan', 'Sudah Meninggal', 'Lainnya',
            ])->nullable(); // based on Dapodik's data
            $table->enum('salary_wali', [
                '< Rp.500.000', 'Rp.500.000 - Rp.999.999', 'Rp.1.000.000 - Rp.1.999.999',
                'Rp.2.000.000 - Rp.4.999.999', 'Rp.5.000.000 - Rp.20.000.000',
                '> Rp.20.000.000', 'Tidak Berpenghasilan',
            ])->nullable(); // based on Dapodik's data


            $table->string('archive_id')->nullable();
            $table->foreign('archive_id')->references('id')->on('archives');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_ulang');
    }
};
