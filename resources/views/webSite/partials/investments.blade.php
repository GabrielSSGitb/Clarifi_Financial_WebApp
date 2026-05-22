@extends('webSite.layouts.basicSetup')

@section('content')
    <section class="max-w-6xl mx-auto">
        <header class="mb-10 flex justify-between items-end">
            <div>
                <h1 class="text-4xl font-bold text-white tracking-tight">Investments</h1>
                <p class="text-gray-500 mt-2">Grow your wealth with smart asset allocation.</p>
            </div>
            <a href="{{route('dashboard.expenses')}}">
                <button class="px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-2xl transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                    + New Asset
                </button>
            </a>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">

            <div class="p-6 rounded-3xl border border-white/10 bg-white/5 backdrop-blur-md">
                <h2 class="text-gray-400 text-xs uppercase tracking-widest mb-4">Total Invested</h2>
                <span class="text-3xl font-bold text-white">R$ 45.200,00</span>
                <div class="mt-4 text-emerald-400 text-sm font-medium">↑ R$ 1.200,50 this month</div>
            </div>

            <div class="p-6 rounded-3xl border border-white/10 bg-gradient-to-br from-indigo-900/40 to-transparent">
                <h2 class="text-gray-400 text-xs uppercase tracking-widest mb-4">Dividends Received</h2>
                <span class="text-3xl font-bold text-white">R$ 312,40</span>
                <div class="mt-4 text-gray-500 text-sm">Yield: 0.8% average</div>
            </div>
        </div>

        @php
            $random = rand(1,2);
        @endphp

        <div class="p-8 rounded-3xl border border-white/10 bg-white/5 shadow-2xl">
            <h2 class="text-xl font-semibold text-white mb-6">Your Portfolio</h2>
            @foreach($investments as $inv)
                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between p-5 rounded-2xl bg-[#080616] border border-white/5 hover:border-indigo-500/50 transition-all cursor-pointer mb-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center font-bold
                       @if($random == 1) text-indigo-400 border @else text-emerald-400 border @endif
                        border-white/10">
                                {{$inv->description}}
                            </div>
                            <div>
                                <div class="text-white font-bold">{{$inv->description}} - investments</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-white font-bold">R$ {{number_format($inv->amount, 2, '.', ',')}}</div>
                            <div class="text-emerald-400 text-xs">+ 4.2%</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
