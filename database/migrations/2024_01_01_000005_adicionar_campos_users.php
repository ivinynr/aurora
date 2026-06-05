<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'tipo')) {
                $table->string('tipo', 50)->default('doador')->after('email');
                $table->index('tipo');
            }

            if (!Schema::hasColumn('users', 'telefone')) {
                $table->string('telefone', 20)->nullable()->after('tipo');
            }

            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('telefone');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'avatar')) {
                $table->dropColumn('avatar');
            }

            if (Schema::hasColumn('users', 'telefone')) {
                $table->dropColumn('telefone');
            }

            if (Schema::hasColumn('users', 'tipo')) {
                $table->dropIndex(['tipo']);
                $table->dropColumn('tipo');
            }
        });
    }
};
