<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $items = Order::with(['business', 'customer'])->latest()->paginate(15);

        return view('orders.index', compact('items'));
    }

    public function create()
    {
        return view('orders.form', [
            'item' => new Order(['order_date' => now()->toDateString(), 'status' => 'New']),
            'businesses' => Business::orderBy('business_name')->get(),
            'customers' => Customer::orderBy('customer_name')->get(),
        ]);
    }

    public function store(OrderRequest $request)
    {
        Order::create($request->validated());

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function edit(Order $order)
    {
        return view('orders.form', [
            'item' => $order,
            'businesses' => Business::orderBy('business_name')->get(),
            'customers' => Customer::orderBy('customer_name')->get(),
        ]);
    }

    public function update(OrderRequest $request, Order $order)
    {
        $order->update($request->validated());

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
