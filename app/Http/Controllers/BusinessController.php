<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessRequest;
use App\Models\Business;

class BusinessController extends Controller
{
    public function index()
    {
        return view('businesses.index', ['items' => Business::latest()->paginate(15)]);
    }

    public function create()
    {
        return view('businesses.form', ['item' => new Business()]);
    }

    public function store(BusinessRequest $request)
    {
        Business::create($request->validated());

        return redirect()->route('businesses.index')->with('success', 'Business created successfully.');
    }

    public function edit(Business $business)
    {
        return view('businesses.form', ['item' => $business]);
    }

    public function update(BusinessRequest $request, Business $business)
    {
        $business->update($request->validated());

        return redirect()->route('businesses.index')->with('success', 'Business updated successfully.');
    }

    public function destroy(Business $business)
    {
        $business->delete();

        return redirect()->route('businesses.index')->with('success', 'Business deleted successfully.');
    }
}
