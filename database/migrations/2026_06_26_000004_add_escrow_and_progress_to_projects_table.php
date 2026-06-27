<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->enum('escrow_status', ['unpaid', 'held_by_admin', 'released'])->default('unpaid')->after('status');
            $table->string('payment_method')->nullable()->after('escrow_status');
            $table->integer('project_progress')->default(0)->after('payment_method');
            $table->string('github_link')->nullable()->after('project_progress');
            $table->string('zip_file')->nullable()->after('github_link');
            $table->string('hosting_link')->nullable()->after('zip_file');
            $table->timestamp('payment_date')->nullable()->after('hosting_link');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'escrow_status',
                'payment_method',
                'project_progress',
                'github_link',
                'zip_file',
                'hosting_link',
                'payment_date'
            ]);
        });
    }
};
