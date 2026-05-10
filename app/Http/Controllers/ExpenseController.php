<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function store(Request $request) {

        $validate = $request->validate([
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'required|string',
            'category' => 'required|string',
        ]);

        Expense::create($validate);

        return redirect()->back();
    }
}
