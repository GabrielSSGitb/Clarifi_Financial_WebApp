@extends('webSite.layouts.basicSetup')

@section('content')
    <section class="max-w-2xl mx-auto pt-10">
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-bold text-white tracking-tight">Future Transactions</h1>
            <p class="text-gray-500 mt-2">Add your next moves for seeing the future.</p>
        </div>


        {{-- ── KPI Cards ───────────────────────────────────────────────────────────── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

            {{-- Balance --}}
            <div class="p-6 flex flex-col gap-4 rounded-3xl border border-white/10 bg-gradient-to-b from-[#1A1953] to-[#080616] shadow-2xl transition-transform hover:scale-[1.02]">
                <div class="flex justify-between items-start">
                    <p class="text-gray-400 font-medium uppercase text-xs tracking-widest">Net Balance</p>
                    <div class="p-2 bg-indigo-500/10 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-3xl font-bold {{ $currentValue >= 0 ? 'text-white' : 'text-red-400' }}">
                        {{ $currentValue < 0 ? '- ' : '' }}R$ {{ number_format(abs($currentValue), 2, ',', '.') }}
                    </p>
                    <p class="text-xs mt-2 {{ $currentValue >= 0 ? 'text-indigo-400' : 'text-red-400' }}">
                        {{ $currentValue >= 0 ? '▲ Positive balance' : '▼ Negative balance' }}
                    </p>
                </div>
                <a href="/dashboard/history"
                   class="mt-auto py-3 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-bold rounded-2xl transition-all shadow-lg shadow-indigo-500/20 active:scale-95 text-center">
                    View History
                </a>
            </div>

            {{-- Incomes --}}
            <div class="p-6 flex flex-col gap-4 rounded-3xl border border-emerald-500/10 bg-gradient-to-b from-emerald-900/20 to-[#080616] shadow-2xl transition-transform hover:scale-[1.02]">
                <div class="flex justify-between items-start">
                    <p class="text-gray-400 font-medium uppercase text-xs tracking-widest">Total Incomes</p>
                    <div class="p-2 bg-emerald-500/10 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-3xl font-bold text-emerald-400">
                        R$ {{ number_format($userIncomes, 2, ',', '.') }}
                    </p>
                    <p class="text-xs text-gray-500 mt-2">
                        {{ $monthNames[$filterMonth] }} {{ $filterYear }}
                    </p>
                </div>
                <a href="/dashboard/incomes"
                   class="mt-auto py-3 bg-emerald-600/20 hover:bg-emerald-600/40 text-emerald-400 text-sm font-bold rounded-2xl transition-all border border-emerald-500/20 active:scale-95 text-center">
                    Add Income
                </a>
            </div>

            {{-- Expenses --}}
            <div class="p-6 flex flex-col gap-4 rounded-3xl border border-red-500/10 bg-gradient-to-b from-red-900/20 to-[#080616] shadow-2xl transition-transform hover:scale-[1.02]">
                <div class="flex justify-between items-start">
                    <p class="text-gray-400 font-medium uppercase text-xs tracking-widest">Total Expenses</p>
                    <div class="p-2 bg-red-500/10 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6 9 12.75l4.286-4.286a11.948 11.948 0 0 1 4.306 6.43l.776 2.898m0 0 3.182-5.511m-3.182 5.51-5.511-3.181"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-3xl font-bold text-red-400">
                        R$ {{ number_format($userExpenses, 2, ',', '.') }}
                    </p>
                    <p class="text-xs text-gray-500 mt-2">
                        {{ $monthNames[$filterMonth] }} {{ $filterYear }}
                    </p>
                </div>
                <a href="/dashboard/expenses"
                   class="mt-auto py-3 bg-red-600/20 hover:bg-red-600/40 text-red-400 text-sm font-bold rounded-2xl transition-all border border-red-500/20 active:scale-95 text-center">
                    Add Expense
                </a>
            </div>

            {{-- Investments --}}
            <div class="p-6 flex flex-col gap-4 rounded-3xl border border-violet-500/10 bg-gradient-to-b from-violet-900/20 to-[#080616] shadow-2xl transition-transform hover:scale-[1.02]">
                <div class="flex justify-between items-start">
                    <p class="text-gray-400 font-medium uppercase text-xs tracking-widest">Investments</p>
                    <div class="p-2 bg-violet-500/10 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-3xl font-bold text-violet-400">
                        R$ {{ number_format($userInvestments, 2, ',', '.') }}
                    </p>
                    <p class="text-xs text-gray-500 mt-2">
                        {{ $monthNames[$filterMonth] }} {{ $filterYear }}
                    </p>
                </div>
                <a href="/dashboard/investments"
                   class="mt-auto py-3 bg-violet-600/20 hover:bg-violet-600/40 text-violet-400 text-sm font-bold rounded-2xl transition-all border border-violet-500/20 active:scale-95 text-center">
                    View Portfolio
                </a>
            </div>

        </div>

        {{-- ── Chart + Quick Actions ───────────────────────────────────────────────── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Bar Chart --}}
            <div class="lg:col-span-2 p-8 rounded-3xl border border-white/10 bg-white/5 backdrop-blur-sm shadow-2xl">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-xl font-semibold text-white">Annual Overview</h2>
                        <p class="text-sm text-gray-500 mt-1">Incomes vs Expenses — {{ $filterYear }}</p>
                    </div>
                    <div class="flex gap-4 text-xs text-gray-400">
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span> Incomes
                </span>
                        <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-red-500 inline-block"></span> Expenses
                </span>
                        <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-violet-500 inline-block"></span> Investments
                </span>
                    </div>
                </div>
                <div class="h-[280px]">
                    <canvas id="mainDashboardChart"></canvas>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="p-8 rounded-3xl border border-white/5 bg-white/5 backdrop-blur-sm flex flex-col gap-6">
                <h2 class="text-gray-400 font-medium uppercase text-xs tracking-widest">Quick Actions</h2>

                <div class="flex flex-col gap-3">
                    <a href="/dashboard/incomes"
                       class="flex items-center gap-3 p-4 bg-emerald-500/5 hover:bg-emerald-500/10 border border-emerald-500/10 rounded-2xl transition-all group">
                        <div class="p-2 bg-emerald-500/10 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white text-sm font-semibold">Add Income</p>
                            <p class="text-gray-500 text-xs">Record a new earning</p>
                        </div>
                    </a>

                    <a href="/dashboard/expenses"
                       class="flex items-center gap-3 p-4 bg-red-500/5 hover:bg-red-500/10 border border-red-500/10 rounded-2xl transition-all group">
                        <div class="p-2 bg-red-500/10 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white text-sm font-semibold">Add Expense</p>
                            <p class="text-gray-500 text-xs">Log a new expense</p>
                        </div>
                    </a>

                    <a href="/dashboard/investments"
                       class="flex items-center gap-3 p-4 bg-violet-500/5 hover:bg-violet-500/10 border border-violet-500/10 rounded-2xl transition-all group">
                        <div class="p-2 bg-violet-500/10 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white text-sm font-semibold">View Portfolio</p>
                            <p class="text-gray-500 text-xs">Track your assets</p>
                        </div>
                    </a>

                    <a href="/dashboard/history"
                       class="flex items-center gap-3 p-4 bg-indigo-500/5 hover:bg-indigo-500/10 border border-indigo-500/10 rounded-2xl transition-all group">
                        <div class="p-2 bg-indigo-500/10 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white text-sm font-semibold">Transaction History</p>
                            <p class="text-gray-500 text-xs">Browse all records</p>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </section>
@endsection
