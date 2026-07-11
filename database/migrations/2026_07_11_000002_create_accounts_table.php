<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->string('account_name');
            $table->enum('account_type', ['Cash', 'Bank', 'UPI', 'Wallet', 'Business Account'])->index();
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['business_id', 'account_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
