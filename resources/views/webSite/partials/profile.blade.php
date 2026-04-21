@extends('webSite.layouts.basicSetup')

@section('content')
    <section class="max-w-5xl mx-auto pb-20">
        <header class="mb-12 flex flex-col md:flex-row items-center gap-8 bg-white/5 p-10 rounded-[3rem] border border-white/10 backdrop-blur-md">
            <div class="relative group">
                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-indigo-500 shadow-lg shadow-indigo-500/20">
                    <img src="{{ asset('images/Profile Picture - Gabriel.jpg') }}" alt="Profile" class="w-full h-full object-cover">
                </div>
                <button class="absolute bottom-0 right-0 p-2 bg-indigo-600 rounded-full text-white border-2 border-[#080616] hover:scale-110 transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15a2.25 2.25 0 0 0 2.25-2.25V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                    </svg>
                </button>
            </div>

            <div class="text-center md:text-left">
                <h1 class="text-3xl font-bold text-white">Gabriel Silva</h1>
                <p class="text-indigo-400">Premium Member • Joined April 2026</p>
                <div class="mt-4 flex gap-3 justify-center md:justify-start">
                    <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-bold rounded-full border border-emerald-500/20">Account Verified</span>
                    <span class="px-3 py-1 bg-white/5 text-gray-400 text-xs font-bold rounded-full border border-white/10">ID: #48291</span>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1 flex flex-col gap-2">
                <a href="#" class="flex items-center gap-4 p-4 bg-indigo-600 text-white rounded-2xl shadow-lg shadow-indigo-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    Personal Info
                </a>
                <a href="#" class="flex items-center gap-4 p-4 text-gray-400 hover:bg-white/5 rounded-2xl transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                    </svg>
                    Security
                </a>
                <a href="#" class="flex items-center gap-4 p-4 text-gray-400 hover:bg-white/5 rounded-2xl transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                    </svg>
                    Notifications
                </a>
            </div>

            <div class="lg:col-span-2 p-8 rounded-[2.5rem] bg-white/5 border border-white/10 shadow-2xl">
                <h2 class="text-xl font-bold text-white mb-8">Personal Information</h2>

                <form action="#" method="POST" class="flex flex-col gap-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="text-xs uppercase tracking-widest text-gray-500">First Name</label>
                            <input type="text" value="Gabriel" class="px-5 py-4 bg-[#080616] border border-white/10 rounded-2xl text-white outline-none focus:border-indigo-500">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="text-xs uppercase tracking-widest text-gray-500">Last Name</label>
                            <input type="text" value="Silva" class="px-5 py-4 bg-[#080616] border border-white/10 rounded-2xl text-white outline-none focus:border-indigo-500">
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-xs uppercase tracking-widest text-gray-500">Email Address</label>
                        <input type="email" value="gabriel@clarifi.com" class="px-5 py-4 bg-[#080616] border border-white/10 rounded-2xl text-white outline-none focus:border-indigo-500">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-xs uppercase tracking-widest text-gray-500">Bio</label>
                        <textarea rows="3" class="px-5 py-4 bg-[#080616] border border-white/10 rounded-2xl text-white outline-none focus:border-indigo-500 resize-none">Focusing on long-term wealth and crypto investments.</textarea>
                    </div>

                    <div class="pt-4 flex justify-end gap-4">
                        <button type="button" class="px-8 py-4 text-gray-400 hover:text-white transition">Cancel</button>
                        <button type="submit" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-2xl shadow-lg shadow-indigo-500/20 transition active:scale-95">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
