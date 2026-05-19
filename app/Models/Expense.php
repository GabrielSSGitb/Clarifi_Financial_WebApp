<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['user_id', 'amount', 'description', 'category', 'date'];

    protected $casts = [
        'amount' => 'float',
        'date' => 'date'
    ];

    public function saveExpense($user_id, $amount, $description, $category, $date) {
        return self::create([
            'user_id' => $user_id,
            'amount' => $amount,
            'description' => $description,
            'category' => $category,
            'date' => $date
        ]);
    }
}
