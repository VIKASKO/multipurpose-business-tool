<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Order;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Collection;

class DashboardService
{
    public function overall(?int $businessId = null): array
    {
        $incomeQuery = Income::query();
        $expenseQuery = Expense::query();
        $accountsQuery = Account::query();

        if ($businessId) {
            $incomeQuery->where('business_id', $businessId);
            $expenseQuery->where('business_id', $businessId);
            $accountsQuery->where('business_id', $businessId);
        }

        $totalIncome = (float) $incomeQuery->sum('amount');
        $totalExpenses = (float) $expenseQuery->sum('amount');

        return [
            'total_income' => $totalIncome,
            'total_expenses' => $totalExpenses,
            'net_profit' => $totalIncome - $totalExpenses,
            'account_balances' => $accountsQuery->get()->mapWithKeys(fn (Account $account) => [$account->account_name => $account->balance]),
            'total_customers' => Customer::when($businessId, fn ($q) => $q->where('business_id', $businessId))->count(),
            'new_customers_this_month' => Customer::when($businessId, fn ($q) => $q->where('business_id', $businessId))
                ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count(),
            'active_projects' => Project::when($businessId, fn ($q) => $q->where('business_id', $businessId))->where('status', 'Active')->count(),
            'completed_projects' => Project::when($businessId, fn ($q) => $q->where('business_id', $businessId))->where('status', 'Completed')->count(),
            'pending_tasks' => Task::when($businessId, fn ($q) => $q->where('business_id', $businessId))->where('status', 'Pending')->count(),
            'overdue_tasks' => Task::when($businessId, fn ($q) => $q->where('business_id', $businessId))->whereDate('due_date', '<', now())->where('status', '!=', 'Completed')->count(),
            'new_orders' => Order::when($businessId, fn ($q) => $q->where('business_id', $businessId))->where('status', 'New')->count(),
            'pending_orders' => Order::when($businessId, fn ($q) => $q->where('business_id', $businessId))->whereIn('status', ['New', 'In Progress', 'Ready'])->count(),
            'delivered_orders' => Order::when($businessId, fn ($q) => $q->where('business_id', $businessId))->where('status', 'Delivered')->count(),
        ];
    }

    public function profitByBusiness(): Collection
    {
        return Business::query()
            ->withSum('incomes', 'amount')
            ->withSum('expenses', 'amount')
            ->get()
            ->map(function (Business $business) {
                $income = (float) ($business->incomes_sum_amount ?? 0);
                $expense = (float) ($business->expenses_sum_amount ?? 0);

                return [
                    'business' => $business->business_name,
                    'income' => $income,
                    'expense' => $expense,
                    'profit' => $income - $expense,
                ];
            });
    }
}
