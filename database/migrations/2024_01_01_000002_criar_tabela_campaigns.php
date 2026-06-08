<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('campaigns')) {
            Schema::create('campaigns', function (Blueprint $table) {
                $table->id();
                $table->foreignId('instituicao_id')->constrained('institutions')->cascadeOnDelete();
                $table->string('titulo');
                $table->string('slug')->unique();
                $table->string('resumo', 255);
                $table->text('descricao');
                $table->string('imagem')->nullable();
                $table->string('video_url')->nullable();
                $table->decimal('meta', 12, 2)->default(0);
                $table->decimal('valor_arrecadado', 12, 2)->default(0);
                $table->string('situacao', 50)->default('rascunho');
                $table->boolean('destaque')->default(false);
                $table->date('data_inicio')->nullable();
                $table->date('data_fim')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->index('situacao');
                $table->index('destaque');
                $table->index(['instituicao_id', 'situacao']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
