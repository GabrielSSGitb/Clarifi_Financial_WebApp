<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Incomes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExportCSVController extends Controller
{
    public function exportDataWithCSV()
    {
        $transactions = [
            ['Date', 'Description', 'Category', 'Amount'],
        ];

        $incomes = Incomes::where('user_id', Auth::id())->get();

        foreach ($incomes as $income) {
            $transactions[] = [
                'Date' => $income->date->format('d-m-Y'),
                'Description' => $income->description,
                'Category' => $income->category,
                'Amount' => $income->amount,
            ];
        }

        $expenses = Expense::where('user_id', Auth::id())->get();

        foreach ($expenses as $expense) {
            $transactions[] = [
                'Date' => $expense->date->format('d-m-Y'),
                'Description' => $expense->description,
                'Category' => $expense->category,
                'Amount' => $expense->amount,
            ];
        }

        $fileName = 'transactions_history_'.date('Y-m-d').'csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$fileName.'"');

        $outputStream = fopen('php://output', 'w');


        foreach ($transactions as $row) {
            fputcsv($outputStream, $row);
        }

        fclose($outputStream);
        exit;
    }
}
