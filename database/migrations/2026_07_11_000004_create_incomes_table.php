<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->foreignId('source_id')->constrained('income_sources')->restrictOnDelete();
            $table->foreignId('account_id')->constrained()->restrictOnDelete();
            $table->date('date')->index();
            $table->decimal('amount', 14, 2);
            $table->string('description');
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['business_id', 'source_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
