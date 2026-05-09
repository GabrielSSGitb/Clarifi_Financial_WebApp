@extends('webSite.layouts.basicSetup')

@section('content')
    <section class="max-w-6xl mx-auto">

        {{-- Header --}}
        <div class="flex justify-between items-end mb-10">
            <div>
                <h1 class="text-4xl font-bold text-white tracking-tight">Transaction History</h1>
                <p class="text-gray-500 mt-2">A detailed overview of all your financial activity.</p>
            </div>
            <div class="flex gap-3">
                <button class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-gray-300 hover:bg-white/10 transition">Export CSV</button>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
            <div class="p-6 rounded-2xl border border-white/10 bg-white/5 backdrop-blur-sm flex flex-col gap-2">
                <span class="text-xs text-gray-500 uppercase tracking-widest">Total Income</span>
                <span class="text-2xl font-bold text-emerald-400">+ R$ 18.500,00</span>
                <span class="text-xs text-gray-500">This month</span>
            </div>
            <div class="p-6 rounded-2xl border border-white/10 bg-white/5 backdrop-blur-sm flex flex-col gap-2">
                <span class="text-xs text-gray-500 uppercase tracking-widest">Total Expenses</span>
                <span class="text-2xl font-bold text-red-400">- R$ 6.050,00</span>
                <span class="text-xs text-gray-500">This month</span>
            </div>
            <div class="p-6 rounded-2xl border border-indigo-500/30 bg-indigo-500/10 backdrop-blur-sm flex flex-col gap-2">
                <span class="text-xs text-indigo-300 uppercase tracking-widest">Net Balance</span>
                <span class="text-2xl font-bold text-white">R$ 12.450,00</span>
                <span class="text-xs text-indigo-300">↑ 12% since last month</span>
            </div>
        </div>

        {{-- Filters & Search --}}
        <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <div class="flex gap-2 p-1 bg-white/5 border border-white/10 rounded-xl w-fit">
                <button onclick="filterTransactions('all', this)"
                    class="filter-btn active-filter px-4 py-2 rounded-lg text-sm font-medium transition-all">All</button>
                <button onclick="filterTransactions('income', this)"
                    class="filter-btn px-4 py-2 rounded-lg text-sm font-medium text-gray-400 hover:text-white transition-all">Income</button>
                <button onclick="filterTransactions('expense', this)"
                    class="filter-btn px-4 py-2 rounded-lg text-sm font-medium text-gray-400 hover:text-white transition-all">Expenses</button>
            </div>

            <div class="relative flex-1 max-w-sm ml-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <input id="searchInput" oninput="searchTransactions(this.value)" type="text" placeholder="Search transactions..."
                    class="w-full pl-9 pr-4 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-white placeholder-gray-500 outline-none focus:border-indigo-500 transition">
            </div>
        </div>

        {{-- Transactions Table --}}
        <div class="overflow-hidden rounded-3xl border border-white/10 bg-white/5 backdrop-blur-md shadow-2xl">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-white/10 bg-white/5">
                        <th class="px-6 py-4 text-gray-400 font-medium text-xs uppercase tracking-wider">Description</th>
                        <th class="px-6 py-4 text-gray-400 font-medium text-xs uppercase tracking-wider">Category</th>
                        <th class="px-6 py-4 text-gray-400 font-medium text-xs uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-gray-400 font-medium text-xs uppercase tracking-wider text-right">Amount</th>
                    </tr>
                </thead>
                <tbody id="transactionsBody" class="divide-y divide-white/5">

                    <tr class="transaction-row hover:bg-white/5 transition-colors" data-type="income" data-desc="Freelance Project">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-emerald-500/20 rounded-lg text-emerald-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </div>
                                <span class="font-medium text-white">Freelance Project</span>
                            </div>
                        </td>
                        <td class="px-6 py-5"><span class="px-2 py-1 bg-emerald-500/10 text-emerald-400 text-xs rounded-lg">Development</span></td>
                        <td class="px-6 py-5 text-gray-400 text-sm">20 Apr, 2026</td>
                        <td class="px-6 py-5 text-right font-bold text-emerald-400">+ R$ 4.500,00</td>
                    </tr>

                    <tr class="transaction-row hover:bg-white/5 transition-colors" data-type="expense" data-desc="Netflix Subscription">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-red-500/20 rounded-lg text-red-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                </div>
                                <span class="font-medium text-white">Netflix Subscription</span>
                            </div>
                        </td>
                        <td class="px-6 py-5"><span class="px-2 py-1 bg-red-500/10 text-red-400 text-xs rounded-lg">Entertainment</span></td>
                        <td class="px-6 py-5 text-gray-400 text-sm">18 Apr, 2026</td>
                        <td class="px-6 py-5 text-right font-bold text-red-400">- R$ 55,90</td>
                    </tr>

                    <tr class="transaction-row hover:bg-white/5 transition-colors" data-type="expense" data-desc="Grocery Store">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-orange-500/20 rounded-lg text-orange-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </div>
                                <span class="font-medium text-white">Grocery Store</span>
                            </div>
                        </td>
                        <td class="px-6 py-5"><span class="px-2 py-1 bg-orange-500/10 text-orange-400 text-xs rounded-lg">Food</span></td>
                        <td class="px-6 py-5 text-gray-400 text-sm">15 Apr, 2026</td>
                        <td class="px-6 py-5 text-right font-bold text-red-400">- R$ 342,15</td>
                    </tr>

                    <tr class="transaction-row hover:bg-white/5 transition-colors" data-type="income" data-desc="Salary">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-emerald-500/20 rounded-lg text-emerald-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </div>
                                <span class="font-medium text-white">Salary</span>
                            </div>
                        </td>
                        <td class="px-6 py-5"><span class="px-2 py-1 bg-emerald-500/10 text-emerald-400 text-xs rounded-lg">Work</span></td>
                        <td class="px-6 py-5 text-gray-400 text-sm">10 Apr, 2026</td>
                        <td class="px-6 py-5 text-right font-bold text-emerald-400">+ R$ 8.000,00</td>
                    </tr>

                    <tr class="transaction-row hover:bg-white/5 transition-colors" data-type="expense" data-desc="Electric Bill">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-yellow-500/20 rounded-lg text-yellow-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                </div>
                                <span class="font-medium text-white">Electric Bill</span>
                            </div>
                        </td>
                        <td class="px-6 py-5"><span class="px-2 py-1 bg-yellow-500/10 text-yellow-400 text-xs rounded-lg">Utilities</span></td>
                        <td class="px-6 py-5 text-gray-400 text-sm">08 Apr, 2026</td>
                        <td class="px-6 py-5 text-right font-bold text-red-400">- R$ 210,00</td>
                    </tr>

                    <tr class="transaction-row hover:bg-white/5 transition-colors" data-type="income" data-desc="Investment Return">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-emerald-500/20 rounded-lg text-emerald-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                </div>
                                <span class="font-medium text-white">Investment Return</span>
                            </div>
                        </td>
                        <td class="px-6 py-5"><span class="px-2 py-1 bg-emerald-500/10 text-emerald-400 text-xs rounded-lg">Investments</span></td>
                        <td class="px-6 py-5 text-gray-400 text-sm">05 Apr, 2026</td>
                        <td class="px-6 py-5 text-right font-bold text-emerald-400">+ R$ 6.000,00</td>
                    </tr>

                    <tr class="transaction-row hover:bg-white/5 transition-colors" data-type="expense" data-desc="Gym Membership">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-purple-500/20 rounded-lg text-purple-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                </div>
                                <span class="font-medium text-white">Gym Membership</span>
                            </div>
                        </td>
                        <td class="px-6 py-5"><span class="px-2 py-1 bg-purple-500/10 text-purple-400 text-xs rounded-lg">Health</span></td>
                        <td class="px-6 py-5 text-gray-400 text-sm">01 Apr, 2026</td>
                        <td class="px-6 py-5 text-right font-bold text-red-400">- R$ 120,00</td>
                    </tr>

                    {{-- Empty state --}}
                    <tr id="emptyState" class="hidden">
                        <td colspan="4" class="px-6 py-16 text-center text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-10 mx-auto mb-3 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            No transactions found.
                        </td>
                    </tr>

                </tbody>
            </table>

            <div class="px-6 py-4 bg-white/5 border-t border-white/10 flex justify-between items-center text-sm text-gray-400">
                <span id="resultCount">Showing 7 results</span>
                <div class="flex gap-2">
                    <button class="px-3 py-1 bg-white/5 rounded-lg hover:bg-white/10 transition opacity-30 cursor-not-allowed">Prev</button>
                    <button class="px-3 py-1 bg-white/5 rounded-lg hover:bg-white/10 transition opacity-30 cursor-not-allowed">Next</button>
                </div>
            </div>
        </div>
    </section>

    <style>
        .active-filter { background: #4f46e5; color: white; }
    </style>

    <script>
        let currentFilter = 'all';
        let currentSearch = '';

        function applyFilters() {
            const rows = document.querySelectorAll('.transaction-row');
            let visible = 0;

            rows.forEach(row => {
                const type = row.dataset.type;
                const desc = row.dataset.desc.toLowerCase();
                const matchFilter = currentFilter === 'all' || type === currentFilter;
                const matchSearch = desc.includes(currentSearch.toLowerCase());

                if (matchFilter && matchSearch) {
                    row.classList.remove('hidden');
                    visible++;
                } else {
                    row.classList.add('hidden');
                }
            });

            document.getElementById('emptyState').classList.toggle('hidden', visible > 0);
            document.getElementById('resultCount').textContent = `Showing ${visible} result${visible !== 1 ? 's' : ''}`;
        }

        function filterTransactions(type, btn) {
            currentFilter = type;
            document.querySelectorAll('.filter-btn').forEach(b => {
                b.classList.remove('active-filter');
                b.classList.add('text-gray-400');
            });
            btn.classList.add('active-filter');
            btn.classList.remove('text-gray-400');
            applyFilters();
        }

        function searchTransactions(value) {
            currentSearch = value;
            applyFilters();
        }
    </script>
@endsection
