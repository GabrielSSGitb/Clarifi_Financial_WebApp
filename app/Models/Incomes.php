<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class Incomes extends Model
{
   protected $fillable = ['amount', 'description', 'category', 'date'];

   protected $casts = [
       'amount' => 'float',
       'date' => 'date'
   ];

   public function saveIncome($amount, $description, $category, $date) {
       return self::create([
          'amount' => $amount,
          'description' => $description,
          'category' => $category,
          'date' => $date
       ]);
   }
}
