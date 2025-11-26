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
        Schema::table('gym_classes', function (Blueprint $table) {
        // Tambah kolom
        $table->enum('status', ['active', 'inactive'])->nullable()->after('name');

        // Hapus kolom
        $table->dropColumn(['capacity', 'duration']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gym_classes', function (Blueprint $table) {
        // Rollback tambah kolom
        $table->dropColumn(['status']);

        // Rollback hapus kolom
        $table->integer('capacity')->default(0);
        $table->integer('duration')->default(60);
    });
    }
};
