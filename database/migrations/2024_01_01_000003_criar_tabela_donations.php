<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('donations')) {
            Schema::create('donations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('instituicao_id')->constrained('institutions')->cascadeOnDelete();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->string('nome_doador');
                $table->string('email_doador')->nullable();
                $table->decimal('valor', 10, 2);
                $table->string('transaction_id')->nullable()->unique();
                $table->string('situacao', 50)->default('pendente');
                $table->boolean('anonimo')->default(false);
                $table->text('mensagem')->nullable();
                $table->timestamps();

                $table->index('situacao');
                $table->index(['instituicao_id', 'situacao']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
