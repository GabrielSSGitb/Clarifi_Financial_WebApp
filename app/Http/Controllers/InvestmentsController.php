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
        $investmentsValues = Expense::find(Auth::id());

        return view('webSite.partials.investments', compact('investmentsValues'));
    }
}
