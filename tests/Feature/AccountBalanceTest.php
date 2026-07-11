<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Business;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Income;
use App\Models\IncomeSource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountBalanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_balance_is_derived_from_income_and_expense_transactions(): void
    {
        $business = Business::create([
            'business_name' => 'Personal',
            'business_type' => 'Personal',
            'status' => 'Active',
        ]);

        $account = Account::create([
            'business_id' => $business->id,
            'account_name' => 'Cash',
            'account_type' => 'Cash',
        ]);

        $source = IncomeSource::create(['source_name' => 'Salary']);
        $category = ExpenseCategory::create(['category_name' => 'Home']);

        Income::create([
            'business_id' => $business->id,
            'source_id' => $source->id,
            'account_id' => $account->id,
            'date' => now()->toDateString(),
            'amount' => 1000,
            'description' => 'Income',
        ]);

        Expense::create([
            'business_id' => $business->id,
            'category_id' => $category->id,
            'account_id' => $account->id,
            'date' => now()->toDateString(),
            'amount' => 250,
            'description' => 'Expense',
        ]);

        $this->assertSame(750.0, $account->fresh()->balance);
    }
}
