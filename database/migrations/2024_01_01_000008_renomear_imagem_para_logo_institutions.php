<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('institutions', function (Blueprint $table) {
            if (Schema::hasColumn('institutions', 'imagem') && ! Schema::hasColumn('institutions', 'logo')) {
                $table->renameColumn('imagem', 'logo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('institutions', function (Blueprint $table) {
            if (Schema::hasColumn('institutions', 'logo') && ! Schema::hasColumn('institutions', 'imagem')) {
                $table->renameColumn('logo', 'imagem');
            }
        });
    }
};
