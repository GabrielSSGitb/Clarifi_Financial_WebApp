<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\Incomes;
use App\Models\User;

class DashboardService
{
    /**
     * Retorna o resumo completo de finanças do usuário para um mês/ano específico.
     */
    public function getDashboardData(int $userId, int $filterMonth, int $filterYear): array
    {
        $currentUser = User::find($userId);

        // Totais do mês
        $userIncomes = (float) Incomes::where('user_id', $userId)
            ->whereMonth('date', $filterMonth)
            ->whereYear('date', $filterYear)
            ->sum('amount');

        $userExpenses = (float) Expense::where('user_id', $userId)
            ->whereMonth('date', $filterMonth)
            ->whereYear('date', $filterYear)
            ->sum('amount');

        $userInvestments = (float) Expense::where('user_id', $userId)
            ->where('category', 'investment')
            ->whereMonth('date', $filterMonth)
            ->whereYear('date', $filterYear)
            ->sum('amount');

        $currentValue = $userIncomes - $userExpenses;

        // Dados para os gráficos
        $chartData = $this->getMonthlyChartData($userId, $filterYear);

        $years = range(date('Y') - 4, (int) date('Y'));

        // Atualização de fechamento no último dia do mês
        $this->updateMonthlyTotalIfLastDay($userId, $currentValue);

        return array_merge([
            'currentUser'     => $currentUser,
            'currentValue'    => $currentValue,
            'userIncomes'     => $userIncomes,
            'userExpenses'    => $userExpenses,
            'userInvestments' => $userInvestments,
            'filterMonth'     => $filterMonth,
            'filterYear'      => $filterYear,
            'years'           => $years,
        ], $chartData);
    }

    /**
     * Gera os totais mensais para os gráficos.
     */
    private function getMonthlyChartData(int $userId, int $year): array
    {
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $chartLabels      = [];
        $chartIncomes     = [];
        $chartExpenses    = [];
        $chartInvestments = [];

        for ($m = 1; $m <= 12; $m++) {
            $chartLabels[] = $monthNames[$m - 1];

            $chartIncomes[] = (float) Incomes::where('user_id', $userId)
                ->whereMonth('date', $m)
                ->whereYear('date', $year)
                ->sum('amount');

            $chartExpenses[] = (float) Expense::where('user_id', $userId)
                ->whereMonth('date', $m)
                ->whereYear('date', $year)
                ->sum('amount');

            $chartInvestments[] = (float) Expense::where('user_id', $userId)
                ->where('category', 'investment')
                ->whereMonth('date', $m)
                ->whereYear('date', $year)
                ->sum('amount');
        }

        return compact('chartLabels', 'chartIncomes', 'chartExpenses', 'chartInvestments');
    }

    /**
     * Regra de fechamento do mês.
     */
    private function updateMonthlyTotalIfLastDay(int $userId, float $currentValue): void
    {
        if ((int) date('d') === (int) date('t')) {
            Incomes::where('user_id', $userId)
                ->latest('MouthLastIncomesTotal')
                ->update(['MouthLastIncomesTotal' => $currentValue]);
        }
    }
}
