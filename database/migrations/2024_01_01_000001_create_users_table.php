<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'programmer', 'umkm', 'course'])->default('programmer');
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();
            // Programmer specific
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_top_programmer')->default(false);
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('total_projects')->default(0);
            $table->decimal('total_earnings', 15, 2)->default(0);
            // UMKM specific
            $table->string('business_name')->nullable();
            $table->string('business_type')->nullable();
            $table->string('legal_doc')->nullable();
            $table->boolean('umkm_verified')->default(false);
            // Course role specific
            $table->string('expertise')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
