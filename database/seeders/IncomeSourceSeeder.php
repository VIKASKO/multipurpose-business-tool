<?php

namespace Database\Seeders;

use App\Models\IncomeSource;
use Illuminate\Database\Seeder;

class IncomeSourceSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Salary', 'Freelance', 'Golden Merita', 'Investment', 'Other'] as $source) {
            IncomeSource::query()->updateOrCreate(['source_name' => $source]);
        }
    }
}
