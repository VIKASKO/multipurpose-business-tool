<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomeRequest;
use App\Models\Account;
use App\Models\Business;
use App\Models\Income;
use App\Models\IncomeSource;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Income::with(['business', 'source', 'account'])->latest();

        if ($request->filled('source_id')) {
            $query->where('source_id', $request->integer('source_id'));
        }

        if ($request->filled('from')) {
            $query->whereDate('date', '>=', $request->date('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('date', '<=', $request->date('to'));
        }

        return view('incomes.index', [
            'items' => $query->paginate(15)->withQueryString(),
            'sources' => IncomeSource::orderBy('source_name')->get(),
        ]);
    }

    public function create()
    {
        return view('incomes.form', [
            'item' => new Income(['date' => now()->toDateString()]),
            'businesses' => Business::orderBy('business_name')->get(),
            'sources' => IncomeSource::orderBy('source_name')->get(),
            'accounts' => Account::orderBy('account_name')->get(),
        ]);
    }

    public function store(IncomeRequest $request)
    {
        Income::create($request->validated());

        return redirect()->route('incomes.index')->with('success', 'Income created successfully.');
    }

    public function edit(Income $income)
    {
        return view('incomes.form', [
            'item' => $income,
            'businesses' => Business::orderBy('business_name')->get(),
            'sources' => IncomeSource::orderBy('source_name')->get(),
            'accounts' => Account::orderBy('account_name')->get(),
        ]);
    }

    public function update(IncomeRequest $request, Income $income)
    {
        $income->update($request->validated());

        return redirect()->route('incomes.index')->with('success', 'Income updated successfully.');
    }

    public function destroy(Income $income)
    {
        $income->delete();

        return redirect()->route('incomes.index')->with('success', 'Income deleted successfully.');
    }
}
