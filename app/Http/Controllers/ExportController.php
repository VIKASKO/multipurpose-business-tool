<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Order;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    private function streamCsv($filename, \Closure $callback)
    {
        return response()->streamDownload($callback, $filename . '_' . date('Y-m-d') . '.csv', [
            'Content-Type' => 'text/csv',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    public function incomes()
    {
        return $this->streamCsv('incomes', function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Date', 'Business', 'Source', 'Account', 'Amount', 'Description', 'Notes']);
            
            Income::with(['business', 'source', 'account'])->chunk(100, function ($items) use ($handle) {
                foreach ($items as $item) {
                    fputcsv($handle, [
                        $item->id,
                        $item->date?->format('Y-m-d'),
                        $item->business->business_name ?? '',
                        $item->source->source_name ?? '',
                        $item->account->account_name ?? '',
                        $item->amount,
                        $item->description,
                        $item->notes
                    ]);
                }
            });
            fclose($handle);
        });
    }

    public function expenses()
    {
        return $this->streamCsv('expenses', function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Date', 'Business', 'Category', 'Account', 'Amount', 'Description', 'Notes']);
            
            Expense::with(['business', 'category', 'account'])->chunk(100, function ($items) use ($handle) {
                foreach ($items as $item) {
                    fputcsv($handle, [
                        $item->id,
                        $item->date?->format('Y-m-d'),
                        $item->business->business_name ?? '',
                        $item->category->category_name ?? '',
                        $item->account->account_name ?? '',
                        $item->amount,
                        $item->description,
                        $item->notes
                    ]);
                }
            });
            fclose($handle);
        });
    }

    public function orders()
    {
        return $this->streamCsv('orders', function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Order Number', 'Business', 'Customer', 'Status', 'Total Amount']);
            
            Order::with(['business', 'customer'])->chunk(100, function ($items) use ($handle) {
                foreach ($items as $item) {
                    fputcsv($handle, [
                        $item->id,
                        $item->order_number,
                        $item->business->business_name ?? '',
                        $item->customer->customer_name ?? '',
                        $item->status,
                        $item->total_amount
                    ]);
                }
            });
            fclose($handle);
        });
    }

    public function customers()
    {
        return $this->streamCsv('customers', function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Business', 'Customer Name', 'Mobile', 'Email', 'Address']);
            
            Customer::with('business')->chunk(100, function ($items) use ($handle) {
                foreach ($items as $item) {
                    fputcsv($handle, [
                        $item->id,
                        $item->business->business_name ?? '',
                        $item->customer_name,
                        $item->mobile,
                        $item->email,
                        $item->address
                    ]);
                }
            });
            fclose($handle);
        });
    }

    public function projects()
    {
        return $this->streamCsv('projects', function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Business', 'Project Name', 'Client Name', 'Status', 'Project Value']);
            
            Project::with('business')->chunk(100, function ($items) use ($handle) {
                foreach ($items as $item) {
                    fputcsv($handle, [
                        $item->id,
                        $item->business->business_name ?? '',
                        $item->project_name,
                        $item->client_name,
                        $item->status,
                        $item->project_value
                    ]);
                }
            });
            fclose($handle);
        });
    }

    public function tasks()
    {
        return $this->streamCsv('tasks', function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Project', 'Task Name', 'Priority', 'Status', 'Due Date', 'Description']);
            
            Task::with('project')->chunk(100, function ($items) use ($handle) {
                foreach ($items as $item) {
                    fputcsv($handle, [
                        $item->id,
                        $item->project->project_name ?? '',
                        $item->task_name,
                        $item->priority,
                        $item->status,
                        $item->due_date?->format('Y-m-d'),
                        $item->description
                    ]);
                }
            });
            fclose($handle);
        });
    }
}
