<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Hapus unique index pada kolom name
            $table->dropUnique(['name']);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Kembalikan jadi unik jika dibatalkan
            $table->unique('name');
        });
    }
};