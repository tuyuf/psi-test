<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Jangan tambahkan 'jenis_kelamin' karena sudah ada
            $table->integer('usia')->nullable();
            $table->integer('masa_kerja')->nullable();
            $table->string('unit_kerja')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['usia', 'masa_kerja', 'unit_kerja']);
        });
    }
};
