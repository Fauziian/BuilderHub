<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('ktp_number')->nullable()->after('city');
            $table->string('ktp_photo')->nullable()->after('ktp_number');
            $table->string('business_photo')->nullable()->after('legal_doc');
            $table->string('cv_file')->nullable()->after('expertise');
            $table->string('portfolio_file')->nullable()->after('cv_file');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['ktp_number', 'ktp_photo', 'business_photo', 'cv_file', 'portfolio_file']);
        });
    }
};
