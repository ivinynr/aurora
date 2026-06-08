<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('payment_transactions')) {
            Schema::create('payment_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('doacao_id')->constrained('donations')->cascadeOnDelete();
                $table->string('gateway', 50)->default('confrapix');
                $table->string('transaction_id')->nullable();
                $table->decimal('valor', 10, 2);
                $table->string('status', 50)->default('pendente');
                $table->text('qr_code')->nullable();
                $table->text('qr_code_text')->nullable();
                $table->timestamp('expira_em')->nullable();
                $table->timestamp('pago_em')->nullable();
                $table->json('payload')->nullable();
                $table->timestamps();

                $table->index('transaction_id');
                $table->index('status');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
