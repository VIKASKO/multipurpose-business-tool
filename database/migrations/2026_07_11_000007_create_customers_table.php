<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->string('customer_name');
            $table->string('mobile', 20)->nullable()->index();
            $table->string('whatsapp', 20)->nullable();
            $table->string('email')->nullable()->index();
            $table->string('address')->nullable();
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['business_id', 'customer_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
