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
        Schema::table('payments', function (Blueprint $table) {
             // Drop foreign key existing
            $table->dropForeign(['bank_id']);

            // Make it nullable
            $table->unsignedBigInteger('bank_id')->nullable()->change();

            // Re-add FK with nullOnDelete
            $table->foreign('bank_id')
                ->references('id')
                ->on('banks')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
             // Drop FK again
            $table->dropForeign(['bank_id']);

            // Revert to NOT NULL
            $table->unsignedBigInteger('bank_id')->nullable(false)->change();

            // Re-add original FK (cascade)
            $table->foreign('bank_id')
                ->references('id')
                ->on('banks')
                ->onDelete('cascade');
        });
    }
};
