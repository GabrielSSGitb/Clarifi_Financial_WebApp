<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Incomes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvestmentsController extends Controller
{
    public function index()
    {
        $investments = Expense::where('user_id', auth()->id())
            ->where('category', 'investment')
            ->get();

        return view('webSite.partials.investments', compact('investments'));
    }
}
