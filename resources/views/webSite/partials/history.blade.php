@extends('webSite.layouts.basicSetup')

@section('content')
    <section class="max-w-6xl mx-auto">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h1 class="text-4xl font-bold text-white tracking-tight">Transactions</h1>
                <p class="text-gray-500 mt-2">Detailed history of your financial activity.</p>
            </div>

            <div class="flex gap-3">
                <button class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-sm hover:bg-white/10 transition">Export CSV</button>
                <button class="px-4 py-2 bg-indigo-600 rounded-xl text-sm font-semibold hover:bg-indigo-500 transition shadow-lg shadow-indigo-500/20">Filter by Date</button>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-white/10 bg-white/5 backdrop-blur-md shadow-2xl">
            <table class="w-full text-left border-collapse">
                <thead>
                <tr class="border-b border-white/10 bg-white/5">
                    <th class="px-6 py-4 text-gray-400 font-medium text-sm uppercase tracking-wider">Description</th>
                    <th class="px-6 py-4 text-gray-400 font-medium text-sm uppercase tracking-wider">Category</th>
                    <th class="px-6 py-4 text-gray-400 font-medium text-sm uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-gray-400 font-medium text-sm uppercase tracking-wider text-right">Amount</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                <tr class="hover:bg-white/5 transition-colors group">
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-emerald-500/20 rounded-lg text-emerald-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <span class="font-medium text-white">Freelance Project</span>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-gray-400">Development</td>
                    <td class="px-6 py-5 text-gray-300 italic text-sm">20 Apr, 2026</td>
                    <td class="px-6 py-5 text-right font-bold text-emerald-400">+ R$ 4.500,00</td>
                </tr>

                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-red-500/20 rounded-lg text-red-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            </div>
                            <span class="font-medium text-white">Netflix Subscription</span>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-gray-400">Entertainment</td>
                    <td class="px-6 py-5 text-gray-300 italic text-sm">18 Apr, 2026</td>
                    <td class="px-6 py-5 text-right font-bold text-white">- R$ 55,90</td>
                </tr>

                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-orange-500/20 rounded-lg text-orange-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <span class="font-medium text-white">Grocery Store</span>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-gray-400">Food</td>
                    <td class="px-6 py-5 text-gray-300 italic text-sm">15 Apr, 2026</td>
                    <td class="px-6 py-5 text-right font-bold text-white">- R$ 342,15</td>
                </tr>
                </tbody>
            </table>

            <div class="px-6 py-4 bg-white/5 border-t border-white/10 flex justify-between items-center text-sm text-gray-400">
                <span>Showing 1-10 of 120 results</span>
                <div class="flex gap-2">
                    <button class="px-3 py-1 bg-white/5 rounded-lg hover:bg-white/10 transition disabled:opacity-30 cursor-not-allowed">Prev</button>
                    <button class="px-3 py-1 bg-white/5 rounded-lg hover:bg-white/10 transition">Next</button>
                </div>
            </div>
        </div>
    </section>
@endsection
