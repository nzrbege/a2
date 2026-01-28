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
        Schema::create('bidang', function (Blueprint $table) {
            $table->id('id_bidang');
            $table->unsignedBigInteger('id_opd');
            $table->string('kode_bidang');
            $table->string('nama_bidang');
            $table->timestamps();

            $table->foreign('id_opd')
                  ->references('id_opd')
                  ->on('opd')
                  ->onDelete('cascade');

            $table->unique(['id_opd', 'kode_bidang']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bidang');
    }
};
