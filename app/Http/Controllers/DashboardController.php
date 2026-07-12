<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(private readonly DashboardService $dashboardService)
    {
    }

    public function index(Request $request)
    {
        $businessId = $request->integer('business_id') ?: null;

        return view('dashboard.index', [
            'businesses' => Business::orderBy('business_name')->get(),
            'selectedBusinessId' => $businessId,
            'overall' => $this->dashboardService->overall($businessId),
            'profitByBusiness' => $this->dashboardService->profitByBusiness(),
        ]);
    }
}
