@php
    date_default_timezone_set('America/Sao_Paulo');
    $hour = (int) date('H');
    $greeting = match(true) {
        $hour < 12 => 'Good morning',
        $hour < 18 => 'Good afternoon',
        $hour < 21 => 'Good evening',
        default    => 'Good night'
    };
    $monthNames = [
        1 => 'January', 2 => 'February', 3 => 'March',    4 => 'April',
        5 => 'May',     6 => 'June',     7 => 'July',      8 => 'August',
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
    ];
@endphp

@extends('webSite.layouts.basicSetup')

@section('content')
    {{-- ── Future Projection Simulator ───────────────────────────────────────── --}}
    <div class="p-8 rounded-3xl border border-white/10 bg-gradient-to-b from-white/5 to-[#080616] backdrop-blur-sm shadow-2xl mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <h2 class="text-xl font-semibold text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m-9-6l2.25-2.25m0 0l2.25 2.25M12 11.25V6" />
                    </svg>
                    Future Financial Simulator
                </h2>
                <p class="text-sm text-gray-500 mt-1">Simulate your projected growth based on initial value, future monthly contributions, and payments.</p>
            </div>
            <div class="flex items-center gap-2 bg-indigo-500/10 border border-indigo-500/20 px-4 py-2 rounded-2xl">
                <span class="text-xs text-indigo-300 font-medium uppercase tracking-wider">Timeline:</span>
                <select id="simMonths" class="bg-transparent text-indigo-400 text-sm font-bold outline-none cursor-pointer">
                    <option value="1" class="bg-[#080616] text-white">1 Month</option>
                    <option value="6" class="bg-[#080616] text-white">6 Months</option>
                    <option value="12" selected class="bg-[#080616] text-white">12 Months (1 Year)</option>
                    <option value="24" class="bg-[#080616] text-white">24 Months (2 Years)</option>
                    <option value="36" class="bg-[#080616] text-white">36 Months (3 Years)</option>
                    <option value="60" class="bg-[#080616] text-white">60 Months (5 Years)</option>
                </select>
            </div>
        </div>

        {{-- Simulation Form Controls --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                <label class="block text-xs uppercase tracking-wider text-gray-400 mb-2">Starting Balance (R$)</label>
                <input type="number" id="simStartingValue" value="{{ $currentValue }}" step="0.01"
                       class="w-full bg-[#080616] text-white border border-white/10 rounded-xl px-4 py-2 text-sm outline-none focus:border-indigo-500 transition-colors">
            </div>

            <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                <label class="block text-xs uppercase tracking-wider text-gray-400 mb-2">Monthly Investment (R$)</label>
                <input type="number" id="simMonthlyInvest" value="{{ $userInvestments }}" step="0.01"
                       class="w-full bg-[#080616] text-white border border-white/10 rounded-xl px-4 py-2 text-sm outline-none focus:border-indigo-500 transition-colors">
            </div>

            <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                <label class="block text-xs uppercase tracking-wider text-gray-400 mb-2">Future Payments / Mo (R$)</label>
                <input type="number" id="simMonthlyExpenses" value="0" step="0.01"
                       class="w-full bg-[#080616] text-white border border-white/10 rounded-xl px-4 py-2 text-sm outline-none focus:border-indigo-500 transition-colors">
            </div>

            <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                <label class="block text-xs uppercase tracking-wider text-gray-400 mb-2">Estimated Yield (% / Mo)</label>
                <input type="number" id="simYieldRate" value="0.8" step="0.1"
                       class="w-full bg-[#080616] text-white border border-white/10 rounded-xl px-4 py-2 text-sm outline-none focus:border-indigo-500 transition-colors">
            </div>
        </div>

        {{-- Projected Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="p-4 rounded-2xl bg-indigo-500/10 border border-indigo-500/20">
                <p class="text-xs text-gray-400 uppercase tracking-widest">Projected Future Balance</p>
                <p id="simResultFinal" class="text-2xl font-bold text-indigo-400 mt-1">R$ 0,00</p>
            </div>
            <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20">
                <p class="text-xs text-gray-400 uppercase tracking-widest">Total Invested</p>
                <p id="simResultInvested" class="text-2xl font-bold text-emerald-400 mt-1">R$ 0,00</p>
            </div>
            <div class="p-4 rounded-2xl bg-violet-500/10 border border-violet-500/20">
                <p class="text-xs text-gray-400 uppercase tracking-widest">Estimated Yield Earnings</p>
                <p id="simResultYield" class="text-2xl font-bold text-violet-400 mt-1">R$ 0,00</p>
            </div>
        </div>

        {{-- Projection Chart --}}
        <div class="h-[280px]">
            <canvas id="simulationChart"></canvas>
        </div>
    </div>

    {{-- ── Chart.js ────────────────────────────────────────────────────────────── --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        (function () {
            // --- Main Dashboard Chart ---
            const labels      = @json($chartLabels);
            const incomes     = @json($chartIncomes);
            const expenses    = @json($chartExpenses);
            const investments = @json($chartInvestments);

            const ctx = document.getElementById('mainDashboardChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [
                            {
                                label: 'Incomes',
                                data: incomes,
                                backgroundColor: 'rgba(52, 211, 153, 0.25)',
                                borderColor: 'rgba(52, 211, 153, 0.9)',
                                borderWidth: 2,
                                borderRadius: 6,
                                borderSkipped: false,
                            },
                            {
                                label: 'Expenses',
                                data: expenses,
                                backgroundColor: 'rgba(248, 113, 113, 0.25)',
                                borderColor: 'rgba(248, 113, 113, 0.9)',
                                borderWidth: 2,
                                borderRadius: 6,
                                borderSkipped: false,
                            },
                            {
                                label: 'Investments',
                                type: 'line',
                                data: investments,
                                borderColor: 'rgba(167, 139, 250, 0.9)',
                                backgroundColor: 'rgba(167, 139, 250, 0.1)',
                                borderWidth: 2,
                                pointBackgroundColor: 'rgba(167, 139, 250, 0.9)',
                                pointRadius: 4,
                                tension: 0.4,
                                fill: false,
                                yAxisID: 'y',
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0d0b1e',
                                borderColor: 'rgba(255,255,255,0.08)',
                                borderWidth: 1,
                                titleColor: '#9ca3af',
                                bodyColor: '#ffffff',
                                padding: 12,
                                callbacks: {
                                    label: (ctx) => ` ${ctx.dataset.label}: R$ ${ctx.parsed.y.toLocaleString('pt-BR', { minimumFractionDigits: 2 })}`,
                                },
                            },
                        },
                        scales: {
                            x: {
                                grid: { color: 'rgba(255,255,255,0.04)' },
                                ticks: { color: '#6b7280', font: { size: 12 } },
                            },
                            y: {
                                grid: { color: 'rgba(255,255,255,0.04)' },
                                ticks: {
                                    color: '#6b7280',
                                    font: { size: 11 },
                                    callback: (v) => 'R$ ' + v.toLocaleString('pt-BR'),
                                },
                                beginAtZero: true,
                            },
                        },
                    },
                });
            }

            // --- Simulator Logic & Chart ---
            let simChartInstance = null;

            function runSimulation() {
                const months = parseInt(document.getElementById('simMonths').value) || 12;
                const startingVal = parseFloat(document.getElementById('simStartingValue').value) || 0;
                const monthlyInvest = parseFloat(document.getElementById('simMonthlyInvest').value) || 0;
                const monthlyExpenses = parseFloat(document.getElementById('simMonthlyExpenses').value) || 0;
                const rate = (parseFloat(document.getElementById('simYieldRate').value) || 0) / 100;

                const simLabels = ['Start'];
                const balanceData = [startingVal];
                const investedData = [startingVal];

                let currentBalance = startingVal;
                let totalInvested = startingVal;
                let totalYield = 0;

                for (let i = 1; i <= months; i++) {
                    simLabels.push(`M${i}`);

                    // Add investment and subtract recurring future expenses/payments
                    currentBalance += (monthlyInvest - monthlyExpenses);
                    totalInvested += monthlyInvest;

                    // Yield calculated over accrued balance
                    const monthYield = Math.max(0, currentBalance) * rate;
                    currentBalance += monthYield;
                    totalYield += monthYield;

                    balanceData.push(currentBalance);
                    investedData.push(totalInvested);
                }

                // Update UI Counters
                document.getElementById('simResultFinal').innerText = 'R$ ' + currentBalance.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                document.getElementById('simResultInvested').innerText = 'R$ ' + totalInvested.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                document.getElementById('simResultYield').innerText = 'R$ ' + totalYield.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

                // Render / Update Simulator Chart
                const simCtx = document.getElementById('simulationChart');
                if (!simCtx) return;

                if (simChartInstance) {
                    simChartInstance.data.labels = simLabels;
                    simChartInstance.data.datasets[0].data = balanceData;
                    simChartInstance.data.datasets[1].data = investedData;
                    simChartInstance.update();
                } else {
                    simChartInstance = new Chart(simCtx, {
                        type: 'line',
                        data: {
                            labels: simLabels,
                            datasets: [
                                {
                                    label: 'Projected Total Balance',
                                    data: balanceData,
                                    borderColor: 'rgba(129, 140, 248, 0.9)',
                                    backgroundColor: 'rgba(129, 140, 248, 0.1)',
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.3,
                                    pointRadius: 3
                                },
                                {
                                    label: 'Total Contributions',
                                    data: investedData,
                                    borderColor: 'rgba(52, 211, 153, 0.8)',
                                    borderWidth: 1.5,
                                    borderDash: [4, 4],
                                    fill: false,
                                    tension: 0.1,
                                    pointRadius: 0
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: { mode: 'index', intersect: false },
                            plugins: {
                                legend: {
                                    display: true,
                                    labels: { color: '#9ca3af', font: { size: 11 } }
                                },
                                tooltip: {
                                    backgroundColor: '#0d0b1e',
                                    borderColor: 'rgba(255,255,255,0.08)',
                                    borderWidth: 1,
                                    titleColor: '#9ca3af',
                                    bodyColor: '#ffffff',
                                    padding: 12,
                                    callbacks: {
                                        label: (ctx) => ` ${ctx.dataset.label}: R$ ${ctx.parsed.y.toLocaleString('pt-BR', { minimumFractionDigits: 2 })}`,
                                    },
                                }
                            },
                            scales: {
                                x: {
                                    grid: { color: 'rgba(255,255,255,0.04)' },
                                    ticks: { color: '#6b7280', font: { size: 11 } }
                                },
                                y: {
                                    grid: { color: 'rgba(255,255,255,0.04)' },
                                    ticks: {
                                        color: '#6b7280',
                                        font: { size: 11 },
                                        callback: (v) => 'R$ ' + v.toLocaleString('pt-BR')
                                    }
                                }
                            }
                        }
                    });
                }
            }

            // Add event listeners to input fields to trigger recalculation on user input
            ['simMonths', 'simStartingValue', 'simMonthlyInvest', 'simMonthlyExpenses', 'simYieldRate'].forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.addEventListener('input', runSimulation);
                    el.addEventListener('change', runSimulation);
                }
            });

            // Initialize simulation on load
            runSimulation();
        })();
    </script>

@endsection
