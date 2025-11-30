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
        Schema::create('gym_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainer_id')->constrained()->onDelete('cascade');
            $table->foreignId('membership_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained('class_categories')->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->integer('capacity')->default(0);
            $table->enum('difficulty', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->integer('duration')->default(60);
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_classes');
    }
};