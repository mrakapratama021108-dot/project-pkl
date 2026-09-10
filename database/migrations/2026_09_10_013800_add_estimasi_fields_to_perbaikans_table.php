<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perbaikans', function (Blueprint $table) {
            $table->decimal('biaya_estimasi', 12, 2)->nullable()->after('bisa_diperbaiki');
            $table->date('tanggal_estimasi_selesai')->nullable()->after('biaya_estimasi');
        });
    }

    public function down(): void
    {
        Schema::table('perbaikans', function (Blueprint $table) {
            $table->dropColumn(['biaya_estimasi', 'tanggal_estimasi_selesai']);
        });
    }
};