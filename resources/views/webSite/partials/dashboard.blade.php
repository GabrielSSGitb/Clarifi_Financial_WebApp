@extends('webSite.layouts.basicSetup')

@section('content')
    <header class="mb-10">
        @php
            date_default_timezone_set('America/Sao_Paulo');
            $hour = (int) date('H');
            $greeting = match(true) {
                $hour < 12 => 'Good morning',
                $hour < 18 => 'Good afternoon',
                $hour < 21 => 'Good evening',
                default => 'Good night'
            };
        @endphp

        <h1 class="text-4xl font-bold tracking-tight text-white">
            {{ $greeting }}, <span class="text-indigo-400">Gabriel!</span>
        </h1>
        <p class="text-gray-500 mt-2">Here's what's happening with your finances today.</p>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        <div class="p-8 flex flex-col gap-6 rounded-3xl border border-white/10 bg-gradient-to-b from-[#1A1953] to-[#080616] shadow-2xl transition-transform hover:scale-[1.02]">
            <div class="flex justify-between items-center">
                <h2 class="text-gray-400 font-medium uppercase text-xs tracking-widest">Current Balance</h2>
                <div class="p-2 bg-emerald-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>

            <div class="flex flex-col">
            <span class="text-5xl font-bold text-white tracking-tighter">
                R$ 12.450,00
            </span>
                <span class="text-sm text-emerald-400 mt-2 flex items-center gap-1">
                ↑ 12% <span class="text-gray-500">since last month</span>
            </span>
            </div>

            <a href="#" class="group mt-4">
                <button class="w-full py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-2xl transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                    Check History
                </button>
            </a>
        </div>

        <div class="p-8 rounded-3xl border border-white/5 bg-white/5 backdrop-blur-sm flex flex-col justify-between">
            <h2 class="text-gray-400 font-medium uppercase text-xs tracking-widest">Quick Actions</h2>
            <div class="grid grid-cols-2 gap-4 mt-6">
                <button class="p-4 bg-white/5 rounded-2xl hover:bg-white/10 transition-all text-sm border border-white/5">Add Income</button>
                <button class="p-4 bg-white/5 rounded-2xl hover:bg-white/10 transition-all text-sm border border-white/5">New Expense</button>
            </div>
            <div class="mt-8 p-4 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 text-sm">
                Pro tip: You saved R$ 200,00 more than last week!
            </div>
        </div>
    </div>

    <div class="mt-10 p-8 rounded-3xl border border-white/10 bg-white/5 backdrop-blur-sm shadow-2xl">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-semibold text-white">Monthly Revenue</h2>
                <p class="text-sm text-gray-500">Overview of your earnings vs expenses</p>
            </div>
            <select class="bg-[#080616] text-white border border-white/10 rounded-lg px-4 py-2 text-sm outline-none focus:border-indigo-500">
                <option>Last 6 Months</option>
                <option>Last Year</option>
            </select>
        </div>

        <div class="h-[300px]">
            <canvas id="mainDashboardChart"></canvas>
        </div>
    </div>
@endsection
