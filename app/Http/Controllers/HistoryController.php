<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Incomes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class HistoryController extends Controller
{
    public function index() {
        $totalIncomes = Incomes::where('user_id', '=', Auth::id())->sum('amount');
        $totalExpenses = Expense::where('user_id', '=', Auth::id())->sum('amount');
        $currentValue = $totalIncomes - $totalExpenses;

        return view('webSite.partials.history', compact(['totalIncomes', 'totalExpenses', 'currentValue']));
    }
}
