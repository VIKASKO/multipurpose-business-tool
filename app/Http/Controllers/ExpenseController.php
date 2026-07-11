<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Models\Account;
use App\Models\Business;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::with(['business', 'category', 'account'])->latest();

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->integer('category_id'));
        }

        if ($request->filled('from')) {
            $query->whereDate('date', '>=', $request->date('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('date', '<=', $request->date('to'));
        }

        return view('expenses.index', [
            'items' => $query->paginate(15)->withQueryString(),
            'categories' => ExpenseCategory::orderBy('category_name')->get(),
        ]);
    }

    public function create()
    {
        return view('expenses.form', [
            'item' => new Expense(['date' => now()->toDateString()]),
            'businesses' => Business::orderBy('business_name')->get(),
            'categories' => ExpenseCategory::orderBy('category_name')->get(),
            'accounts' => Account::orderBy('account_name')->get(),
        ]);
    }

    public function store(ExpenseRequest $request)
    {
        Expense::create($request->validated());

        return redirect()->route('expenses.index')->with('success', 'Expense created successfully.');
    }

    public function edit(Expense $expense)
    {
        return view('expenses.form', [
            'item' => $expense,
            'businesses' => Business::orderBy('business_name')->get(),
            'categories' => ExpenseCategory::orderBy('category_name')->get(),
            'accounts' => Account::orderBy('account_name')->get(),
        ]);
    }

    public function update(ExpenseRequest $request, Expense $expense)
    {
        $expense->update($request->validated());

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
