<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // expenses: composite index for common filtered queries
        Schema::table('expenses', function (Blueprint $table) {
            $table->index(['business_id', 'category_id', 'date'], 'expenses_business_category_date_idx');
        });

        // customers: index for date-range queries by business
        Schema::table('customers', function (Blueprint $table) {
            $table->index(['business_id', 'created_at'], 'customers_business_created_idx');
        });

        // tasks: index for status + due_date filtering
        Schema::table('tasks', function (Blueprint $table) {
            $table->index(['business_id', 'status', 'due_date'], 'tasks_business_status_due_idx');
        });

        // orders: index for date-range queries
        Schema::table('orders', function (Blueprint $table) {
            $table->index(['business_id', 'order_date'], 'orders_business_date_idx');
        });

        // incomes: already has composite index, add account_id filter index
        Schema::table('incomes', function (Blueprint $table) {
            $table->index(['account_id', 'date'], 'incomes_account_date_idx');
        });
    }

    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropIndex('expenses_business_category_date_idx');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex('customers_business_created_idx');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex('tasks_business_status_due_idx');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('orders_business_date_idx');
        });

        Schema::table('incomes', function (Blueprint $table) {
            $table->dropIndex('incomes_account_date_idx');
        });
    }
};
