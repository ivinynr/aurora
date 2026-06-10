<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            if (! Schema::hasColumn('donations', 'campanha_id')) {
                $table->foreignId('campanha_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('campaigns')
                    ->nullOnDelete();

                $table->index(['campanha_id', 'situacao']);
            }
        });

        Schema::table('institutions', function (Blueprint $table) {
            if (Schema::hasColumn('institutions', 'meta')) {
                $table->dropColumn('meta');
            }

            if (Schema::hasColumn('institutions', 'valor_arrecadado')) {
                $table->dropColumn('valor_arrecadado');
            }

            if (Schema::hasColumn('institutions', 'video_url')) {
                $table->dropColumn('video_url');
            }
        });

        Schema::table('payment_transactions', function (Blueprint $table) {
            if (Schema::hasColumn('payment_transactions', 'status')) {
                $table->renameColumn('status', 'situacao');
            }
        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            if (Schema::hasColumn('donations', 'campanha_id')) {
                $table->dropForeign(['campanha_id']);
                $table->dropIndex(['campanha_id', 'situacao']);
                $table->dropColumn('campanha_id');
            }
        });

        Schema::table('institutions', function (Blueprint $table) {
            if (! Schema::hasColumn('institutions', 'meta')) {
                $table->decimal('meta', 12, 2)->default(0)->after('missao');
            }

            if (! Schema::hasColumn('institutions', 'valor_arrecadado')) {
                $table->decimal('valor_arrecadado', 12, 2)->default(0)->after('meta');
            }

            if (! Schema::hasColumn('institutions', 'video_url')) {
                $table->string('video_url')->nullable()->after('imagem');
            }
        });

        Schema::table('payment_transactions', function (Blueprint $table) {
            if (Schema::hasColumn('payment_transactions', 'situacao')) {
                $table->renameColumn('situacao', 'status');
            }
        });
    }
};
