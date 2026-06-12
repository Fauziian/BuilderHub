<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->decimal('budget', 15, 2);
            $table->date('deadline');
            $table->enum('status', ['pending', 'open', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->string('category');
            $table->json('tags')->nullable();
            $table->foreignId('assigned_programmer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('platform_fee', 15, 2)->default(0);
            $table->decimal('programmer_earning', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
