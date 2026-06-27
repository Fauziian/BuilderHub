<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->string('portfolio_file')->nullable()->after('project_url');
        });

        Schema::table('certificates', function (Blueprint $table) {
            $table->string('certificate_file')->nullable()->after('credential_url');
        });
    }

    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn('portfolio_file');
        });

        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn('certificate_file');
        });
    }
};
