<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Models\Account;
use App\Models\Business;

class AccountController extends Controller
{
    public function index()
    {
        $items = Account::with('business')->latest()->paginate(15);

        return view('accounts.index', compact('items'));
    }

    public function create()
    {
        return view('accounts.form', ['item' => new Account(), 'businesses' => Business::orderBy('business_name')->get()]);
    }

    public function store(AccountRequest $request)
    {
        Account::create($request->validated());

        return redirect()->route('accounts.index')->with('success', 'Account created successfully.');
    }

    public function edit(Account $account)
    {
        return view('accounts.form', ['item' => $account, 'businesses' => Business::orderBy('business_name')->get()]);
    }

    public function update(AccountRequest $request, Account $account)
    {
        $account->update($request->validated());

        return redirect()->route('accounts.index')->with('success', 'Account updated successfully.');
    }

    public function destroy(Account $account)
    {
        $account->delete();

        return redirect()->route('accounts.index')->with('success', 'Account deleted successfully.');
    }
}
