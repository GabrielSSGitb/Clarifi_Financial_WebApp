<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Clarifi - Create Account</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#080616] flex items-center justify-center min-h-screen p-6 overflow-x-hidden">

<div class="absolute top-0 -right-4 w-96 h-96 bg-indigo-600 rounded-full mix-blend-multiply filter blur-[128px] opacity-20"></div>
<div class="absolute bottom-0 -left-4 w-96 h-96 bg-emerald-600 rounded-full mix-blend-multiply filter blur-[128px] opacity-20"></div>

<main class="w-full max-w-xl relative">
    <div class="flex flex-col items-center mb-8">
        <img src="{{asset('build/assets/images/Clarifi_Logo.png')}}" alt="Clarifi Logo" class="w-14 mb-4">
        <h1 class="text-3xl font-bold text-white tracking-tight">Create your account</h1>
        <p class="text-gray-500 mt-2">Start managing your finances with Clarifi today.</p>
    </div>

    <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-8 md:p-10 rounded-[2.5rem] shadow-2xl">
        <!-- Add the action method here!! -->
        <form action="/register/new-user" method="POST" class="flex flex-col gap-5">
            @csrf

            <div class="flex flex-col gap-2">
                <label for="name" class="text-xs uppercase tracking-widest text-gray-400 ml-1">Name</label>
                <input type="text" name="name" id="name" placeholder="YourName..." required
                       class="w-full px-5 py-4 bg-[#080616]/50 border border-white/10 rounded-2xl text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
            </div>

            <div class="flex flex-col gap-2">
                <label for="email" class="text-xs uppercase tracking-widest text-gray-400 ml-1">Email Address</label>
                <input type="email" name="email" id="email" placeholder="youremail@example.com" required
                       class="w-full px-5 py-4 bg-[#080616]/50 border border-white/10 rounded-2xl text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="flex flex-col gap-2">
                    <label for="password" class="text-xs uppercase tracking-widest text-gray-400 ml-1">Password</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" required
                           class="w-full px-5 py-4 bg-[#080616]/50 border border-white/10 rounded-2xl text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
                </div>
                <div class="flex flex-col gap-2">
                    <label for="password_confirmation" class="text-xs uppercase tracking-widest text-gray-400 ml-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" required
                           class="w-full px-5 py-4 bg-[#080616]/50 border border-white/10 rounded-2xl text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
                </div>
            </div>

            <label class="flex items-start gap-3 cursor-pointer group mt-2">
                <input type="checkbox" required class="mt-1 w-5 h-5 rounded border-white/10 bg-[#080616] text-emerald-500 focus:ring-offset-[#080616]">
                <span class="text-sm text-gray-400 group-hover:text-gray-300 transition">
                        I agree to the <a href="#" class="text-indigo-400 underline">Terms of Service</a> and <a href="#" class="text-indigo-400 underline">Privacy Policy</a>.
                    </span>
            </label>

            <button type="submit"
                    class="w-full py-4 mt-4 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-2xl transition-all shadow-lg shadow-emerald-500/20 active:scale-[0.98]">
                Create Account
            </button>
        </form>
    </div>

    <p class="text-center mt-8 text-gray-500 text-sm">
        Already have an account?
        <a href="/clarifi/login" class="text-white font-semibold hover:text-indigo-400 transition">Sign in here</a>
    </p>
</main>

</body>
</html>
