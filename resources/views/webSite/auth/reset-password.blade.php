<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Clarifi - Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#080616] flex items-center justify-center min-h-screen p-6 overflow-hidden">

<div class="absolute top-0 -left-4 w-72 h-72 bg-indigo-600 rounded-full mix-blend-multiply filter blur-[128px] opacity-20"></div>
<div class="absolute bottom-0 -right-4 w-72 h-72 bg-emerald-600 rounded-full mix-blend-multiply filter blur-[128px] opacity-20"></div>

<main class="w-full max-w-md relative">
    <div class="flex flex-col items-center mb-8">
        <img src="{{asset('build/assets/images/Clarifi_Oficial_Logo-removebg-preview.png')}}" alt="Clarifi Logo" class="w-50 mb-4">
        <h1 class="text-3xl font-bold text-white tracking-tight">Welcome back</h1>
        <p class="text-gray-500 mt-2">Enter your credentials to access Clarifi</p>
    </div>

    <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-10 rounded-[2.5rem] shadow-2xl">
        <!-- Add the action method here!! -->
        <form method="POST" class="flex flex-col gap-6">
            @csrf

            <div class="flex flex-col gap-2">
                <label for="email" class="text-xs uppercase tracking-widest text-gray-400 ml-1">Email Address</label>
                <input type="email" name="email" id="email" placeholder="name@company.com" required
                       class="w-full px-5 py-4 bg-[#080616]/50 border border-white/10 rounded-2xl text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all placeholder:text-gray-700">
            </div>

            <div class="flex flex-col gap-2">
                <div class="flex justify-between items-center ml-1">
                    <label for="password" class="text-xs uppercase tracking-widest text-gray-400">Password</label>
                </div>
                <input type="password" name="password" id="password" placeholder="••••••••" required
                       class="w-full px-5 py-4 bg-[#080616]/50 border border-white/10 rounded-2xl text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all placeholder:text-gray-700">
            </div>

            <label class="flex items-center gap-3 cursor-pointer group w-fit">
                <input type="checkbox" class="w-5 h-5 rounded border-white/10 bg-[#080616] text-indigo-600 focus:ring-offset-[#080616]">
                <span class="text-sm text-gray-400 group-hover:text-gray-300 transition">Remember me</span>
            </label>

            <button type="submit"
                    class="w-full py-4 mt-2 bg-emerald-600 hover:bg-emerald-500  text-white font-bold rounded-2xl transition-all shadow-lg shadow-indigo-500/20 active:scale-[0.98]">
                Sign In
            </button>
        </form>
    </div>

    <p class="text-center mt-2 text-gray-500 text-sm">
        Don't have an account?
        <a href="{{ route('register') }}" class="text-white font-semibold hover:text-indigo-400 transition pl-2">Create one for free</a>
    </p>
    <p class="text-center mt-2 text-gray-500 text-sm">

        <a href="/forgot-password" class="hover:text-indigo-400 transition">I forgot my password</a>
    </p>
</main>

</body>
</html>
