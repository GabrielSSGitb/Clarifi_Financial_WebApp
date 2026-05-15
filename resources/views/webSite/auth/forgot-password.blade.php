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
        <h1 class="text-3xl font-bold text-white tracking-tight">Reset Your Password</h1>
    </div>

    <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-10 rounded-[2.5rem] shadow-2xl">
        <!-- Add the action method here!! -->
        <form method="POST" class="flex flex-col gap-6" action="/reset-password">
            @csrf

            <div class="flex flex-col gap-2">
                <label for="email" class="text-xs uppercase tracking-widest text-gray-400 ml-1">Email Address</label>
                <input type="email" name="email" id="email" placeholder="name@company.com" required
                       class="w-full px-5 py-4 bg-[#080616]/50 border border-white/10 rounded-2xl text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all placeholder:text-gray-700">
            </div>

            <button type="submit"
                    class="w-full py-4 mt-2 bg-emerald-600 hover:bg-emerald-500  text-white font-bold rounded-2xl transition-all shadow-lg shadow-indigo-500/20 active:scale-[0.98]">
                Send a reset link to my email
            </button>
        </form>
    </div>

    <p class="text-center mt-2 text-gray-500 text-sm">
        Remember your access?
        <a href="{{ route('login') }}" class="text-white font-semibold hover:text-indigo-400 transition pl-2">Go back to sign in</a>
    </p>
</main>

</body>
</html>
