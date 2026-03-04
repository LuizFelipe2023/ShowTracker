<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-900 text-slate-200 font-sans antialiased relative overflow-hidden">
        
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-2xl h-96 bg-indigo-600/10 blur-[120px] pointer-events-none"></div>

        <div class="z-10 text-center">
            <Link :href="route('shows.index')" class="flex flex-col items-center gap-4 group">
                <div class="bg-indigo-600 p-4 rounded-2xl group-hover:bg-indigo-500 transition-all shadow-2xl shadow-indigo-500/20 group-active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.2 6L3 11V4a1 1 0 0 1 1-1h15.2a1 1 0 0 1 1-1v2z"></path>
                        <path d="M3 11v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V11H3z"></path>
                        <path d="M3 11l17.2-5"></path>
                        <path d="M8 11v11"></path>
                        <path d="M13 11v11"></path>
                    </svg>
                </div>
                <div class="flex flex-col leading-none">
                    <span class="font-black text-white tracking-tighter text-3xl uppercase italic underline decoration-indigo-500 decoration-8 underline-offset-4">
                        MY<span class="text-indigo-400">SHOWS</span>
                    </span>
                    <span class="text-[10px] text-slate-500 font-bold tracking-[0.4em] uppercase mt-2">Watchlist Manager</span>
                </div>
            </Link>
        </div>

        <div
            class="w-full sm:max-w-md mt-10 px-8 py-10 bg-slate-800 border border-slate-700 shadow-2xl overflow-hidden sm:rounded-[2.5rem] z-10"
        >
            <slot />
        </div>

        <div class="mt-8 z-10">
            <p class="text-[9px] font-black text-slate-600 uppercase tracking-[0.4em]">
                &copy; {{ new Date().getFullYear() }} MyShows — Cinema Experience
            </p>
        </div>
    </div>
</template>