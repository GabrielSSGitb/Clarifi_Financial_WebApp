<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clarifi - Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#080616] text-white flex flex-col md:flex-row min-h-screen font-sans pb-20 md:pb-0">

<aside class="group fixed bottom-0 left-0 w-full h-16 md:sticky md:top-0 md:w-20 md:hover:w-56 md:h-screen bg-[#1A1953]/40 md:bg-[#1A1953]/20 backdrop-blur-xl border-t md:border-t-0 md:border-r border-white/5 flex flex-row md:flex-col items-center md:items-start py-0 md:py-8 justify-around md:justify-start gap-0 md:gap-6 transition-all duration-300 overflow-hidden z-50">

    <div class="hidden md:flex w-full px-4 items-center gap-3 mb-2">
        <img src="{{asset('build/assets/images/Clarifi_icon.png')}}" alt="Logo" class="w-10 h-10 object-contain flex-shrink-0">
        <span class="opacity-0 group-hover:opacity-100 whitespace-nowrap font-bold text-white text-lg transition-opacity duration-200 delay-100">DashBoard</span>
    </div>

    <nav class="flex flex-row md:flex-col justify-around md:justify-start gap-1 md:gap-2 w-full px-2 md:px-3 h-full md:h-auto items-center md:items-stretch">

        <a href="{{route('dashboard')}}" class="flex flex-col md:flex-row items-center gap-1 md:gap-3 p-2 md:p-3 bg-indigo-600 rounded-xl md:rounded-2xl text-white shadow-lg shadow-indigo-500/40 transition-all flex-1 md:flex-none justify-center md:justify-start">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 md:size-6 flex-shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
            </svg>
            <span class="text-[10px] md:text-sm font-medium md:opacity-0 md:group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200 delay-100">Home</span>
        </a>

        <a href="{{route('dashboard.incomes')}}" class="flex flex-col md:flex-row items-center gap-1 md:gap-3 p-2 md:p-3 text-gray-500 hover:text-emerald-400 hover:bg-white/5 rounded-xl md:rounded-2xl transition-all flex-1 md:flex-none justify-center md:justify-start">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 md:size-6 flex-shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
            <span class="text-[10px] md:text-sm font-medium md:opacity-0 md:group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200 delay-100">Incomes</span>
        </a>

        <a href="{{route('dashboard.expenses')}}" class="flex flex-col md:flex-row items-center gap-1 md:gap-3 p-2 md:p-3 text-gray-500 hover:text-red-400 hover:bg-white/5 rounded-xl md:rounded-2xl transition-all flex-1 md:flex-none justify-center md:justify-start">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 md:size-6 flex-shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
            </svg>
            <span class="text-[10px] md:text-sm font-medium md:opacity-0 md:group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200 delay-100">Expenses</span>
        </a>

        <a href="{{route('dashboard.history')}}" class="flex flex-col md:flex-row items-center gap-1 md:gap-3 p-2 md:p-3 text-gray-500 hover:text-indigo-400 hover:bg-white/5 rounded-xl md:rounded-2xl transition-all flex-1 md:flex-none justify-center md:justify-start">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 md:size-6 flex-shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
            <span class="text-[10px] md:text-sm font-medium md:opacity-0 md:group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200 delay-100">History</span>
        </a>

        <a href="{{route('dashboard.investments')}}" class="sm:flex flex-col md:flex-row items-center gap-1 md:gap-3 p-2 md:p-3 text-gray-500 hover:text-emerald-400 hover:bg-white/5 rounded-xl md:rounded-2xl transition-all flex-1 md:flex-none justify-center md:justify-start">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 md:size-6 flex-shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
            </svg>
            <span class="text-[10px] md:text-sm font-medium md:opacity-0 md:group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200 delay-100">Investments</span>
        </a>

        <a href="{{route('dashboard.calendar')}}" class="sm:flex flex-col md:flex-row items-center gap-1 md:gap-3 p-2 md:p-3 text-gray-500 hover:text-emerald-400 hover:bg-white/5 rounded-xl md:rounded-2xl transition-all flex-1 md:flex-none justify-center md:justify-start">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 md:size-6 flex-shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z" />
            </svg>
            <span class="text-[10px] md:text-sm font-medium md:opacity-0 md:group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200 delay-100">Calendar</span>
        </a>
    </nav>

    <a href="{{route('profile')}}" class="md:mt-auto flex flex-col md:flex-row items-center gap-1 md:gap-3 p-2 md:p-3 text-gray-500 hover:text-white hover:bg-white/5 rounded-xl md:rounded-2xl transition-all px-2 md:px-3 justify-center md:justify-start">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 md:size-6 flex-shrink-0">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
        </svg>
        <span class="text-[10px] md:text-sm font-medium md:opacity-0 md:group-hover:opacity-100 whitespace-nowrap transition-opacity duration-200 delay-100">Profile</span>
    </a>
</aside>

<main class="flex-1 p-4 sm:p-6 md:p-10 overflow-y-auto w-full max-w-full">
    @yield('content')
</main>

<div class="fixed bottom-20 right-6 md:bottom-6 md:right-6 z-[100] flex flex-col items-end gap-4 font-sans">

    <section id="globalCalculator" class="hidden w-72 p-5 rounded-3xl border border-white/10 bg-[#1A1953]/30 backdrop-blur-xl shadow-2xl shadow-indigo-900/40 transition-all duration-300 transform scale-95 origin-bottom-right">

        <div class="mb-4 bg-[#080616]/60 border border-white/5 rounded-2xl p-4 text-right overflow-hidden">
            <div id="calcHistory" class="text-xs text-gray-500 min-h-[1rem] tracking-wide truncate"></div>
            <div id="calcDisplay" class="text-2xl font-bold text-white tracking-tight mt-1 truncate">0</div>
        </div>

        <div class="grid grid-cols-4 gap-2 text-sm font-semibold">
            <button class="calc-btn bg-white/5 hover:bg-white/10 text-red-400 p-3 rounded-xl transition active:scale-95" data-action="clear">C</button>
            <button  id="deleteLineBtn" class="bg-white/5 hover:bg-white/10 text-indigo-400 p-3 rounded-xl flex items-center justify-center transition active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75 14.25 12m0 0 2.25 2.25M14.25 12l2.25-2.25M14.25 12 12 14.25m-2.58 4.92-6.374-6.375a1.125 1.125 0 0 1 0-1.59L9.42 4.83c.21-.211.497-.33.795-.33H19.5a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25h-9.284c-.298 0-.585-.119-.795-.33Z" />
                </svg>
            </button>
            <button class="calc-btn bg-white/5 hover:bg-white/10 text-indigo-400 p-3 rounded-xl transition active:scale-95" data-val="^">^</button>
            <button class="calc-btn bg-indigo-600/20 hover:bg-indigo-600/40 text-indigo-400 p-3 rounded-xl transition active:scale-95 font-bold" data-val="/">/</button>

            <button class="calc-btn bg-white/5 hover:bg-white/10 text-white p-3 rounded-xl transition active:scale-95" data-val="7">7</button>
            <button class="calc-btn bg-white/5 hover:bg-white/10 text-white p-3 rounded-xl transition active:scale-95" data-val="8">8</button>
            <button class="calc-btn bg-white/5 hover:bg-white/10 text-white p-3 rounded-xl transition active:scale-95" data-val="9">9</button>
            <button class="calc-btn bg-indigo-600/20 hover:bg-indigo-600/40 text-indigo-400 p-3 rounded-xl transition active:scale-95 font-bold" data-val="*">*</button>

            <button class="calc-btn bg-white/5 hover:bg-white/10 text-white p-3 rounded-xl transition active:scale-95" data-val="4">4</button>
            <button class="calc-btn bg-white/5 hover:bg-white/10 text-white p-3 rounded-xl transition active:scale-95" data-val="5">5</button>
            <button class="calc-btn bg-white/5 hover:bg-white/10 text-white p-3 rounded-xl transition active:scale-95" data-val="6">6</button>
            <button class="calc-btn bg-indigo-600/20 hover:bg-indigo-600/40 text-indigo-400 p-3 rounded-xl transition active:scale-95 font-bold" data-val="-">-</button>

            <button class="calc-btn bg-white/5 hover:bg-white/10 text-white p-3 rounded-xl transition active:scale-95" data-val="1">1</button>
            <button class="calc-btn bg-white/5 hover:bg-white/10 text-white p-3 rounded-xl transition active:scale-95" data-val="2">2</button>
            <button class="calc-btn bg-white/5 hover:bg-white/10 text-white p-3 rounded-xl transition active:scale-95" data-val="3">3</button>
            <button class="calc-btn bg-indigo-600/20 hover:bg-indigo-600/40 text-indigo-400 p-3 rounded-xl transition active:scale-95 font-bold" data-val="+">+</button>

            <button class="calc-btn bg-white/5 hover:bg-white/10 text-white p-3 rounded-xl transition active:scale-95" data-val="0">0</button>
            <button class="calc-btn bg-white/5 hover:bg-white/10 text-white p-3 rounded-xl transition active:scale-95" data-val=".">.</button>
            <button id="equalBtn"  class="col-span-2 bg-indigo-600 hover:bg-indigo-500 text-white p-3 rounded-xl transition shadow-lg shadow-indigo-600/20 active:scale-95 text-center font-bold">=</button>
        </div>
    </section>

    <button id="toggleCalculatorBtn" class="w-14 h-14 bg-indigo-600 hover:bg-indigo-500 text-white rounded-full flex items-center justify-center transition-all duration-200 shadow-xl shadow-indigo-600/30 active:scale-95 border border-white/10">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-3-2.25h.008v.008H12.75V15.75Zm0 2.25h.008v.008H12.75V18Zm-3-2.25h.008v.008H9.75V15.75Zm0 2.25h.008v.008H9.75V18ZM9.75 6h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 8.625 11.625v-4.5C8.625 6.504 9.124 6 9.75 6ZM3.75 6h.008v.008H3.75V6Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 9h.008v.008H3.75V9Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 3h.008v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 3h.008v.008H3.75V15Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 3h.008v.008H3.75V18Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
        </svg>
    </button>
</div>

<script src="@vite('resources/js/calculatorDisplay.js')"></script>
<script src="@vite('resources/js/calculatorFunctions.js')"></script>
</body>
</html>
