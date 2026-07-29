<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FutureTransactionsController extends Controller
{

    protected DashboardService $dashboardService;

    // Injeção de dependência pelo construtor do controller
    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request)
    {
        $userId      = Auth::id();
        $filterMonth = (int) $request->get('month', date('m'));
        $filterYear  = (int) $request->get('year', date('Y'));

        // Reaproveita todos os cálculos e dados estruturados
        $dashboardData = $this->dashboardService->getDashboardData($userId, $filterMonth, $filterYear);

        return view('webSite.partials.futureTransactions', $dashboardData);
    }
}
