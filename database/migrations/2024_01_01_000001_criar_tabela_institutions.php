<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('institutions')) {
            Schema::create('institutions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('nome');
                $table->string('slug')->unique();
                $table->text('descricao');
                $table->string('missao')->nullable();
                $table->string('logo')->nullable();
                $table->string('telefone', 20)->nullable();
                $table->string('email')->nullable();
                $table->string('instagram', 100)->nullable();
                $table->string('website')->nullable();
                $table->string('chave_pix')->nullable();
                $table->string('endereco')->nullable();
                $table->string('cidade', 100)->nullable();
                $table->string('estado', 2)->nullable();
                $table->boolean('ativa')->default(true);
                $table->timestamps();
                $table->softDeletes();

                $table->index('cidade');
                $table->index('estado');
                $table->index('ativa');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('institutions');
    }
};
