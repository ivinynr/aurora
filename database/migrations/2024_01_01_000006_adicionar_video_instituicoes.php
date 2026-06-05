<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('institutions', 'video_url')) {
            Schema::table('institutions', function (Blueprint $table) {
                $table->string('video_url')->nullable()->after('imagem');
            });
        }
    }

    public function down(): void
    {
        Schema::table('institutions', function (Blueprint $table) {
            $table->dropColumn('video_url');
        });
    }
};
