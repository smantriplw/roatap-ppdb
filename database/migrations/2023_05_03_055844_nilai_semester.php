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
        Schema::create('nilai_semester', function(Blueprint $table) {
            $table->id();

            $table->string('lesson');
            $table->integer('s1');
            $table->integer('s2');
            $table->integer('s3');
            $table->integer('s4');
            $table->integer('s5');
            $table->string('archive_id')->nullable();

            $table->foreign('archive_id')->references('id')->on('archives');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_semester');
    }
};
