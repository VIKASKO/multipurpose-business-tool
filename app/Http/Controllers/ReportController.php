<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Income;
use App\Models\IncomeSource;
use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->date('from') ?? now()->startOfMonth();
        $to = $request->date('to') ?? now()->endOfMonth();

        $incomeQuery = Income::query()->whereBetween('date', [$from, $to]);
        if ($request->filled('source_id')) {
            $incomeQuery->where('source_id', $request->integer('source_id'));
        }

        $expenseQuery = Expense::query()->whereBetween('date', [$from, $to]);
        if ($request->filled('category_id')) {
            $expenseQuery->where('category_id', $request->integer('category_id'));
        }

        $totalIncome = (float) $incomeQuery->sum('amount');
        $totalExpense = (float) $expenseQuery->sum('amount');

        return view('reports.index', [
            'from' => $from,
            'to' => $to,
            'sources' => IncomeSource::orderBy('source_name')->get(),
            'categories' => ExpenseCategory::orderBy('category_name')->get(),
            'ordersByStatus' => Order::all()->groupBy('status')->map->count(),
            'monthlyRevenue' => Order::all()
                ->groupBy(fn (Order $order) => optional($order->order_date)->format('Y-m'))
                ->map(fn ($orders) => $orders->sum('total_amount'))
                ->sortKeys(),
            'incomeTotal' => $totalIncome,
            'expenseTotal' => $totalExpense,
            'profitTotal' => $totalIncome - $totalExpense,
        ]);
    }
}
