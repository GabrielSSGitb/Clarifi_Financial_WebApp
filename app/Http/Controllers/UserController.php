<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Incomes;
use App\Models\User;
use http\Exception\RuntimeException;
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
    public function currentValue($currentUserId, $currentUser)
    {

        $currentMonth = date('m');

        $currentYear = date('Y');

        $userIncomes = Incomes::query()
            ->where('user_id', $currentUserId)
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');

        $userExpenses = Expense::query()
            ->where('user_id', $currentUserId)
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');

        $daysInMouth = Date('t');

        $currentValue = $userIncomes - $userExpenses;

        if(Date('d') == $daysInMouth) {
            Incomes::query()->where('user_id', $currentUserId)->latest('MouthLastIncomesTotal')->update(['MouthLastIncomesTotal' => $currentValue]);
        }

        return view('webSite.home', compact(['currentUser', 'currentValue']));
    }

    public function update(Request $request) {

        User::query()->where('id', Auth::id())->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

       return redirect('/')->with('User updated successfully');
    }
}
