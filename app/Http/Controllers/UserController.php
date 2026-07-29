<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index(Request $request, DashboardService $dashboardService)
    {
        $userId      = Auth::id();
        $filterMonth = (int) $request->get('month', date('m'));
        $filterYear  = (int) $request->get('year', date('Y'));

        // Chama o serviço centralizado
        $data = $dashboardService->getDashboardData($userId, $filterMonth, $filterYear);

        return view('webSite.home', $data);
    }

    public function update(Request $request)
    {
        User::query()->where('id', Auth::id())->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect('/')->with('User updated successfully');
    }
}
