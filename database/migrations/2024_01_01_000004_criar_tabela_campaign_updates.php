<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('campaign_updates')) {
            Schema::create('campaign_updates', function (Blueprint $table) {
                $table->id();
                $table->foreignId('campanha_id')->constrained('campaigns')->cascadeOnDelete();
                $table->string('titulo');
                $table->text('descricao');
                $table->string('imagem')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_updates');
    }
};
