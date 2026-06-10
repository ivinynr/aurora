<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $indices = collect(DB::select('SHOW INDEX FROM institutions WHERE Key_name = "institutions_slug_index"'));

        if ($indices->isNotEmpty()) {
            Schema::table('institutions', function (Blueprint $table) {
                $table->dropIndex('institutions_slug_index');
            });
        }
    }

    public function down(): void
    {
        Schema::table('institutions', function (Blueprint $table) {
            if (! collect(DB::select('SHOW INDEX FROM institutions WHERE Key_name = "institutions_slug_index"'))->count()) {
                $table->index('slug');
            }
        });
    }
};
