<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuan_bukus', function (Blueprint $table) {
            $table->string('npsn')->nullable()->after('pemohon');
            $table->string('satuan_pendidikan')->nullable()->after('npsn');
            $table->date('tanggal_estimasi')->nullable()->after('metode');
        });
    }

    public function down(): void
    {
        Schema::table('pengajuan_bukus', function (Blueprint $table) {
            $table->dropColumn(['npsn', 'satuan_pendidikan', 'tanggal_estimasi']);
        });
    }
};