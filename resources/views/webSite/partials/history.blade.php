@extends('webSite.layouts.basicSetup')

@section('content')
    <section class="history-section">

        {{-- Header --}}
        <div class="history-header">
            <div>
                <h1 class="history-title">Transaction History</h1>
                <p class="history-subtitle">A detailed overview of all your financial activity.</p>
            </div>
            <div class="header-actions">
                <button class="btn-secondary">Export CSV</button>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="summary-grid">
            <div class="summary-card card-income">
                <span class="card-label">Total Income</span>
                <span class="card-value value-income">+ R$ {{number_format($totalIncomes, 2, '.', ',')}}</span>
                <span class="card-subtext">This month</span>
            </div>
            <div class="summary-card card-expense">
                <span class="card-label">Total Expenses</span>
                <span class="card-value value-expense">- R$ {{number_format($totalExpenses, 2, '.', ',')}}</span>
                <span class="card-subtext">This month</span>
            </div>
            <div class="summary-card card-balance">
                <span class="card-label balance-label">Net Balance</span>
                <span class="card-value value-balance">R$ {{number_format($currentValue, 2, '.', ',')}}</span>
                <span class="card-subtext balance-subtext">↑ 12% since last month</span>
            </div>
        </div>

        {{-- Filters & Search --}}
        <div class="toolbar-flex">
            <div class="filter-wrapper">
                <button onclick="filterTransactions('all', this)"
                        class="filter-btn active-filter">All</button>
                <button onclick="filterTransactions('income', this)"
                        class="filter-btn text-muted">Income</button>
                <button onclick="filterTransactions('expense', this)"
                        class="filter-btn text-muted">Expenses</button>
            </div>

            <div class="search-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" class="search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <input id="searchInput" oninput="searchTransactions(this.value)" type="text" placeholder="Search transactions..." class="search-input">
            </div>
        </div>

        {{-- Transactions Table --}}
        <div class="table-container">
            <table class="transactions-table">
                <thead>
                <tr class="table-header-row">
                    <th class="th-column text-left">Description</th>
                    <th class="th-column text-left">Category</th>
                    <th class="th-column text-left">Date</th>
                    <th class="th-column text-right">Amount</th>
                </tr>
                </thead>
                <tbody id="transactionsBody" class="table-body">

                @foreach($incomes as $income)
                    <tr class="transaction-row row-income" data-type="income" data-desc="{{$income->description}}">
                        <td class="td-cell">
                            <div class="description-block">
                                <div class="icon-box box-income">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </div>
                                <span class="description-title">{{$income->description}}</span>
                            </div>
                        </td>
                        <td class="td-cell"><span class="badge badge-income">{{$income->category}}</span></td>
                        <td class="td-cell text-muted text-sm">{{$income->date->format("d-m-Y")}}</td>
                        <td class="td-cell text-right font-bold value-income">+ R$ {{number_format($income->amount, 2, '.', ',')}}</td>
                    </tr>
                @endforeach

                @foreach($expenses as $expense)
                    @if($expense->category == 'food')
                        <tr class="transaction-row row-expense" data-type="expense" data-desc="{{$expense->description}}">
                            <td class="td-cell">
                                <div class="description-block">
                                    <div class="icon-box box-food">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    </div>
                                    <span class="description-title">{{$expense->description}}</span>
                                </div>
                            </td>
                            <td class="td-cell"><span class="badge badge-food">Food</span></td>
                            <td class="td-cell text-muted text-sm">{{$expense->date->format("d-m-Y")}}</td>
                            <td class="td-cell text-right font-bold value-expense">- R$ {{number_format($expense->amount, 2, '.', ',')}}</td>
                        </tr>
                    @endif

                    @if($expense->category == 'investment')
                        <tr class="transaction-row row-expense" data-type="expense" data-desc="{{$expense->description}}">
                            <td class="td-cell">
                                <div class="description-block">
                                    <div class="icon-box box-investment">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="svg-icon">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                                        </svg>
                                    </div>
                                    <span class="description-title">{{$expense->description}}</span>
                                </div>
                            </td>
                            <td class="td-cell"><span class="badge badge-investment">Investment</span></td>
                            <td class="td-cell text-muted text-sm">{{$expense->date->format("d-m-Y")}}</td>
                            <td class="td-cell text-right font-bold value-expense">- R$ {{number_format($expense->amount, 2, '.', ',')}}</td>
                        </tr>
                    @endif

                    {{-- Outros tipos de despesas padrão --}}
                    @if($expense->category != 'food' && $expense->category != 'investment')
                        <tr class="transaction-row row-expense" data-type="expense" data-desc="{{$expense->description}}">
                            <td class="td-cell">
                                <div class="description-block">
                                    <div class="icon-box box-expense">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                    </div>
                                    <span class="description-title">{{$expense->description}}</span>
                                </div>
                            </td>
                            <td class="td-cell"><span class="badge badge-expense">{{$expense->category}}</span></td>
                            <td class="td-cell text-muted text-sm">{{$expense->date->format("d-m-Y")}}</td>
                            <td class="td-cell text-right font-bold value-expense">- R$ {{number_format($expense->amount, 2, '.', ',')}}</td>
                        </tr>
                    @endif
                @endforeach

                <tr id="emptyState" class="hidden">
                    <td colspan="4" class="empty-state-cell">
                        <svg xmlns="http://www.w3.org/2000/svg" class="empty-state-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        No transactions found.
                    </td>
                </tr>

                </tbody>
            </table>

            {{-- Footer Table --}}
            <div class="table-footer">
                <span id="resultCount">Showing 7 results</span>
                <div class="footer-actions">
                    <button class="btn-pagination disabled">Prev</button>
                    <button class="btn-pagination disabled">Next</button>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* --- ESTRUTURA GERAL --- */
        .history-section {
            max-width: 1152px;
            margin-left: auto;
            margin-right: auto;
        }
        .text-muted { color: #6b7280; }
        .text-sm { font-size: 0.875rem; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .font-bold { font-weight: 700; }
        .hidden { display: none !important; }

        /* --- HEADER --- */
        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 2.5rem;
        }
        .history-title {
            font-size: 2.25rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.025em;
            margin: 0;
        }
        .history-subtitle {
            color: #6b7280;
            margin-top: 0.5rem;
            margin-bottom: 0;
        }
        .btn-secondary {
            padding: 0.5rem 1rem;
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.75rem;
            font-size: 0.875rem;
            color: #d1d5db;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .btn-secondary:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* --- SUMMARY CARDS --- */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }
        @media (min-width: 640px) {
            .summary-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        }
        .summary-card {
            padding: 1.5rem;
            border-radius: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background-color: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(4px);
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .card-balance {
            border-color: rgba(79, 70, 229, 0.3);
            background-color: rgba(79, 70, 229, 0.1);
        }
        .card-label {
            font-size: 0.75rem;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        .balance-label { color: #a5b4fc; }
        .card-value {
            font-size: 1.5rem;
            font-weight: 700;
        }
        .value-income { color: #34d399; }
        .value-expense { color: #f87171; }
        .value-balance { color: #ffffff; }
        .card-subtext {
            font-size: 0.75rem;
            color: #6b7280;
        }
        .balance-subtext { color: #a5b4fc; }

        /* --- TOOLBAR (FILTERS & SEARCH) --- */
        .toolbar-flex {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        @media (min-width: 640px) {
            .toolbar-flex { flex-direction: row; }
        }
        .filter-wrapper {
            display: flex;
            gap: 0.5rem;
            padding: 0.25rem;
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.75rem;
            width: fit-content;
        }
        .filter-btn {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        .filter-btn.text-muted:hover { color: #ffffff; }
        .active-filter {
            background: #4f46e5;
            color: #ffffff !important;
        }
        .search-wrapper {
            position: relative;
            flex: 1 1 0%;
            max-width: 24rem;
        }
        @media (min-width: 640px) {
            .search-wrapper { margin-left: auto; }
        }
        .search-icon {
            width: 1rem;
            height: 1rem;
            color: #6b7280;
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
        }
        .search-input {
            width: 100%;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            padding-left: 2.25rem;
            padding-right: 1rem;
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.75rem;
            font-size: 0.875rem;
            color: #ffffff;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }
        .search-input::placeholder { color: #555; }
        .search-input:focus { border-color: #4f46e5; }

        /* --- TABLE --- */
        .table-container {
            overflow: hidden;
            border-radius: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background-color: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        .transactions-table {
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }
        .table-header-row {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background-color: rgba(255, 255, 255, 0.05);
        }
        .th-column {
            padding: 1rem 1.5rem;
            color: #9ca3af;
            font-weight: 500;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .table-body tr + tr {
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
        .transaction-row {
            transition: background-color 0.2s;
        }
        .transaction-row:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }
        .td-cell {
            padding: 1.25rem 1.5rem;
        }
        .description-block {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* --- CLASSES DINÂMICAS --- */
        .description-title {
            font-weight: 500;
            color: #ffffff;
        }
        .icon-box {
            padding: 0.5rem;
            border-radius: 0.5rem;
        }
        .svg-icon {
            width: 1.25rem;
            height: 1.25rem;
            display: block;
        }

        /* Cores dos Ícones (Fundo e SVG) */
        .box-income { background-color: rgba(52, 211, 153, 0.2); color: #34d399; }
        .box-expense { background-color: rgba(248, 113, 113, 0.2); color: #f87171; }
        .box-food { background-color: rgba(251, 146, 60, 0.2); color: #fb923c; }
        .box-yellow { background-color: rgba(250, 204, 21, 0.2); color: #facc15; }
        .box-purple { background-color: rgba(192, 132, 252, 0.2); color: #c084fc; }

        /* NOVA CLASSE: Ícone de Investimento (Estilo Ciano Elétrico) */
        .box-investment { background-color: rgba(6, 182, 212, 0.2); color: #06b6d4; }

        /* Badges de Categoria */
        .badge {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            border-radius: 0.5rem;
            display: inline-block;
        }
        .badge-income { background-color: rgba(52, 211, 153, 0.1); color: #34d399; }
        .badge-expense { background-color: rgba(248, 113, 113, 0.1); color: #f87171; }
        .badge-food { background-color: rgba(251, 146, 60, 0.1); color: #fb923c; }
        .badge-yellow { background-color: rgba(250, 204, 21, 0.1); color: #facc15; }
        .badge-purple { background-color: rgba(192, 132, 252, 0.1); color: #c084fc; }

        /* NOVA CLASSE: Badge de Investimento */
        .badge-investment { background-color: rgba(6, 182, 212, 0.1); color: #06b6d4; }

        /* --- EMPTY STATE & FOOTER --- */
        .empty-state-cell {
            padding: 4rem 1.5rem;
            text-align: center;
            color: #6b7280;
        }
        .empty-state-icon {
            width: 2.5rem;
            height: 2.5rem;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 0.75rem;
            opacity: 0.3;
        }
        .table-footer {
            padding: 1rem 1.5rem;
            background-color: rgba(255, 255, 255, 0.05);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.875rem;
            color: #6b7280;
        }
        .footer-actions { display: flex; gap: 0.5rem; }
        .btn-pagination {
            padding: 0.25rem 0.75rem;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 0.5rem;
            border: none;
            color: inherit;
            transition: background-color 0.2s;
        }
        .btn-pagination.disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }
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
                b.classList.add('text-muted');
            });
            btn.classList.add('active-filter');
            btn.classList.remove('text-muted');
            applyFilters();
        }

        function searchTransactions(value) {
            currentSearch = value;
            applyFilters();
        }
    </script>
@endsection
