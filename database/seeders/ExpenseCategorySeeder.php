<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Home', 'Groceries', 'Fuel', 'Internet', 'Hosting', 'Marketing', 'Fabric Purchase', 'Miscellaneous'] as $category) {
            ExpenseCategory::query()->updateOrCreate(['category_name' => $category]);
        }
    }
}
