<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'businesses',
            'accounts',
            'incomes',
            'expenses',
            'customers',
            'orders',
            'projects',
            'tasks',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->after('id');
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'businesses',
            'accounts',
            'incomes',
            'expenses',
            'customers',
            'orders',
            'projects',
            'tasks',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropConstrainedForeignId('created_by');
            });
        }
    }
};
