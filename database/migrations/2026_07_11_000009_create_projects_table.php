<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->string('project_name');
            $table->string('client_name');
            $table->date('start_date')->nullable()->index();
            $table->date('end_date')->nullable()->index();
            $table->decimal('project_value', 14, 2)->default(0);
            $table->enum('status', ['Planning', 'Active', 'Testing', 'Completed', 'Cancelled'])->default('Planning')->index();
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['business_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
