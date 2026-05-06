<?php

namespace App\Http\Controllers;

use App\Models\Incomes;
use Illuminate\Http\Request;

class IncomesController
{
    public function store(Request $request) {

        $validate = $request->validate([
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'required|string',
            'category' => 'required|string',
        ]);

        Incomes::create($validate);

        return redirect()->back();
    }
}
