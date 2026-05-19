<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{


    public function show() {
        return view('webSite.partials.expense');
    }

    public function store(Request $request) {

        $validate = $request->validate([
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'required|string',
            'category' => 'required|string',
        ]);

        Expense::create([
            'user_id' => Auth::id(),
            'amount' => $validate['amount'],
            'date' => $validate['date'],
            'description' => $validate['description'],
            'category' => $validate['category'],
        ]);

        return redirect()->back();
    }
}
