@extends('webSite.layouts.basicSetup')

@section('content')
    <section class="max-w-2xl mx-auto pt-10">
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-bold text-white tracking-tight">Add Income</h1>
            <p class="text-gray-500 mt-2">Record your earnings to keep your dashboard updated.</p>
        </div>

        <div class="p-8 rounded-3xl border border-white/10 bg-white/5 backdrop-blur-md shadow-2xl">
            <form action="#" method="POST" class="flex flex-col gap-6">
                @csrf

                <div class="flex flex-col gap-2">
                    <label for="amount" class="text-xs uppercase tracking-widest text-gray-400 ml-1">Amount (R$)</label>
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-red-900 font-bold text-xl">R$</span>
                        <input type="number" step="0.01" name="amount" id="amount" placeholder="0,00" required
                               class="w-full pl-14 pr-5 py-5 bg-[#080616] border border-white/10 rounded-2xl text-3xl font-bold text-white focus:border-red-900 focus:ring-1 focus:ring-red-900 outline-none transition-all placeholder:text-gray-700">
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="description" class="text-xs uppercase tracking-widest text-gray-400 ml-1">Description</label>
                    <input type="text" name="description" id="description" placeholder="Ex: Netflix, Gas, Shopping..." required
                           class="w-full px-5 py-4 bg-[#080616] border border-white/10 rounded-xl text-white focus:border-indigo-500 outline-none transition-all">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label for="category" class="text-xs uppercase tracking-widest text-gray-400 ml-1">Category</label>
                        <select name="category" id="category"
                                class="w-full px-5 py-4 bg-[#080616] border border-white/10 rounded-xl text-white focus:border-indigo-500 outline-none transition-all appearance-none">
                            <option value="Clothing">Clothing</option>
                            <option value="School">School</option>
                            <option value="gift">Gift</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="date" class="text-xs uppercase tracking-widest text-gray-400 ml-1">Date</label>
                        <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}"
                               class="w-full px-5 py-4 bg-[#080616] border border-white/10 rounded-xl text-white focus:border-indigo-500 outline-none transition-all">
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit"
                            class="w-full py-5 bg-red-500 hover:bg-red-300 text-[#080616] font-black uppercase tracking-widest rounded-2xl transition-all shadow-lg shadow-emerald-500/20 active:scale-[0.98]">
                        Save Transaction
                    </button>

                    <a href="{{ url()->previous() }}" class="block text-center mt-6 text-gray-500 hover:text-white text-sm transition">
                        Cancel and go back
                    </a>
                </div>
            </form>
        </div>
    </section>
@endsection
