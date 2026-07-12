<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->enum('business_type', ['Personal', 'Boutique', 'Freelance', 'Software', 'Investment', 'Other'])->index();
            $table->text('description')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active')->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
