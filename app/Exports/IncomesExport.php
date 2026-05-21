<?php

namespace App\Exports;

use App\Models\Incomes;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IncomesExport implements WithHeadings, FromQuery
{

    protected $userId;

    /**
     * @param $userId
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
    * @return \Illuminate\Database\Query\Builder
     */

    public function query()
    {
        $incomes = DB::table('incomes')
            ->select('description', 'category', 'amount', 'date', DB::raw("'Receita' as type"))
            ->where('user_id', $this->userId);

        return DB::table('expenses')
            ->select('description', 'category', 'amount', 'date', DB::raw("'Despesa' as type"))
            ->where('user_id', $this->userId)
            ->union($incomes)
            ->orderBy('date', 'desc');
    }

    public function headings(): array
    {
        return [
            'Description',
            'Category',
            'Amount ($)',
            'Date',
        ];
    }

}
