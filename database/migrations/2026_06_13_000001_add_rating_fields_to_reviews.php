<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Type: 'umkm' = rating dari UMKM untuk project selesai
            //        'course' = rating dari pelajar untuk course selesai
            $table->enum('type', ['umkm', 'course'])->default('umkm')->after('comment');
            // course_id diisi hanya jika type = 'course'
            $table->foreignId('course_id')->nullable()->constrained()->onDelete('cascade')->after('type');
            // project_id sekarang nullable (untuk course review tidak perlu project)
            $table->foreignId('project_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropColumn(['type', 'course_id']);
            $table->foreignId('project_id')->nullable(false)->change();
        });
    }
};
