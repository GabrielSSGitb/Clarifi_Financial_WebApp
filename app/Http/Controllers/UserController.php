<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Incomes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $currentUserId = Auth::id();
        $currentUser   = User::query()->find($currentUserId);

        $filterMonth = (int) $request->get('month', date('m'));
        $filterYear  = (int) $request->get('year', date('Y'));

        $userIncomes = Incomes::query()
            ->where('user_id', $currentUserId)
            ->whereMonth('date', $filterMonth)
            ->whereYear('date', $filterYear)
            ->sum('amount');

        $userExpenses = Expense::query()
            ->where('user_id', $currentUserId)
            ->whereMonth('date', $filterMonth)
            ->whereYear('date', $filterYear)
            ->sum('amount');

        $userInvestments = Expense::query()
            ->where('user_id', $currentUserId)
            ->where('category', 'investment')
            ->whereMonth('date', $filterMonth)
            ->whereYear('date', $filterYear)
            ->sum('amount');

        $currentValue = $userIncomes - $userExpenses;

        $monthNames       = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $chartLabels      = [];
        $chartIncomes     = [];
        $chartExpenses    = [];
        $chartInvestments = [];

        for ($m = 1; $m <= 12; $m++) {
            $chartLabels[] = $monthNames[$m - 1];

            $chartIncomes[] = (float) Incomes::query()
                ->where('user_id', $currentUserId)
                ->whereMonth('date', $m)
                ->whereYear('date', $filterYear)
                ->sum('amount');

            $chartExpenses[] = (float) Expense::query()
                ->where('user_id', $currentUserId)
                ->whereMonth('date', $m)
                ->whereYear('date', $filterYear)
                ->sum('amount');

            $chartInvestments[] = (float) Expense::query()
                ->where('user_id', $currentUserId)
                ->where('category', 'investment')
                ->whereMonth('date', $m)
                ->whereYear('date', $filterYear)
                ->sum('amount');
        }

        $years = range(date('Y') - 4, (int) date('Y'));

        $daysInMonth = (int) date('t');
        if ((int) date('d') === $daysInMonth) {
            Incomes::query()
                ->where('user_id', $currentUserId)
                ->latest('MouthLastIncomesTotal')
                ->update(['MouthLastIncomesTotal' => $currentValue]);
        }

        return view('webSite.home', compact(
            'currentUser',
            'currentValue',
            'userIncomes',
            'userExpenses',
            'userInvestments',
            'chartLabels',
            'chartIncomes',
            'chartExpenses',
            'chartInvestments',
            'filterMonth',
            'filterYear',
            'years'
        ));
    }

    public function update(Request $request)
    {
        User::query()->where('id', Auth::id())->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect('/')->with('User updated successfully');
    }
}
