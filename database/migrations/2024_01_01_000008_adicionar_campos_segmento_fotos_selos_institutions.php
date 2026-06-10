<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('institutions', function (Blueprint $table) {
            if (! Schema::hasColumn('institutions', 'segmento')) {
                $table->string('segmento', 50)->nullable()->after('ativa');
                $table->index('segmento');
            }

            if (! Schema::hasColumn('institutions', 'fotos')) {
                $table->json('fotos')->nullable()->after('logo');
            }

            if (! Schema::hasColumn('institutions', 'selos')) {
                $table->json('selos')->nullable()->after('fotos');
            }
        });
    }

    public function down(): void
    {
        Schema::table('institutions', function (Blueprint $table) {
            if (Schema::hasColumn('institutions', 'segmento')) {
                $table->dropIndex(['segmento']);
                $table->dropColumn('segmento');
            }

            if (Schema::hasColumn('institutions', 'fotos')) {
                $table->dropColumn('fotos');
            }

            if (Schema::hasColumn('institutions', 'selos')) {
                $table->dropColumn('selos');
            }
        });
    }
};
