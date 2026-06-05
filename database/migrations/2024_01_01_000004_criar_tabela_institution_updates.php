<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('institution_updates')) {
            Schema::create('institution_updates', function (Blueprint $table) {
                $table->id();
                $table->foreignId('instituicao_id')->constrained('institutions')->cascadeOnDelete();
                $table->string('titulo');
                $table->text('descricao');
                $table->string('imagem')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('institution_updates');
    }
};
