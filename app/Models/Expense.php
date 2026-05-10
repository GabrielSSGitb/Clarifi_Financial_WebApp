<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['amount', 'description', 'category', 'date'];

    protected $casts = [
        'amount' => 'float',
        'date' => 'date'
    ];

    public function saveExpense($amount, $description, $category, $date) {
        return self::create([
            'amount' => $amount,
            'description' => $description,
            'category' => $category,
            'date' => $date
        ]);
    }
}
