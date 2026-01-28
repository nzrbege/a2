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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id_opd')->nullable()->after('id');
            $table->unsignedBigInteger('id_bidang')->nullable()->after('id_opd');

            $table->foreign('id_opd')->references('id_opd')->on('opd');
            $table->foreign('id_bidang')->references('id_bidang')->on('bidang');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_opd']);
            $table->dropForeign(['id_bidang']);

            $table->dropColumn(['id_opd', 'id_bidang']);
        });
    }
};
