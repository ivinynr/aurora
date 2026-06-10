<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            if (Schema::hasColumn('donations', 'instituicao_id')) {
                $table->dropForeign(['instituicao_id']);
                $table->dropIndex('donations_instituicao_id_situacao_index');
                $table->dropColumn('instituicao_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            if (! Schema::hasColumn('donations', 'instituicao_id')) {
                $table->foreignId('instituicao_id')
                    ->nullable()
                    ->after('campanha_id')
                    ->constrained('institutions')
                    ->nullOnDelete();

                $table->index(['instituicao_id', 'situacao']);
            }
        });
    }
};
