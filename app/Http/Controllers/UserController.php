<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Incomes;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index() {
        $currentUserId = Auth::id();
        $currentUser = User::query()->find($currentUserId);

        return $this->currentValue($currentUserId, $currentUser);
    }

    /**
     * @throws \Exception
     */
    public function currentValue($currentUserId, $currentUser) {

        $userIncomes = Incomes::query()->where('user_id', '=', $currentUserId)->get()->toArray();
        $userExpenses = Expense::query()->where('user_id', '=', $currentUserId)->get()->toArray();
        $currentValue = 0.00;

        if(!empty($userExpenses) && !empty($userIncomes)) {
            foreach ($userExpenses as $expense) {
                $currentValue -= $expense['amount'];
            }
            foreach ($userIncomes as $income) {
                $currentValue += $income['amount'];
            }
        }else if(!empty($userExpenses)) {
            foreach ($userIncomes as $income) {
                $currentValue += $income['amount'];
            }
        }else {
            throw new \Exception('Nothing on the database to display');
        }
        return view('webSite.home', compact('currentUser', 'currentValue'));
    }
}
