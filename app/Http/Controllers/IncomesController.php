<?php

namespace App\Http\Controllers;

use App\Models\Incomes;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use MongoDB\Driver\Session;

class IncomesController
{
    public function store(Request $request) {

        $validate = $request->validate([
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'required|string',
            'category' => 'required|string',
        ]);

        Incomes::create([
            'user_id'     => Auth::id(),
            'amount'      => $validate['amount'],
            'date'        => $validate['date'],
            'description' => $validate['description'],
            'category'    => $validate['category'],
        ]);

        return redirect()->back();
    }

    public function show()
    {
        return view('webSite.partials.incomes');
    }
}
