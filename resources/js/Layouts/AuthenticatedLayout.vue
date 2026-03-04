<script setup>
import { ref } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="min-h-screen flex flex-col bg-slate-900 text-slate-200 font-sans antialiased"> 
        
        <nav class="bg-slate-800/80 backdrop-blur-xl border-b border-slate-700 sticky top-0 z-50 shadow-xl flex-none">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    
                    <div class="flex items-center">
                        <Link :href="route('shows.index')" class="flex items-center gap-3 group">
                            <div class="bg-indigo-600 p-2.5 rounded-xl group-hover:bg-indigo-500 transition-all shadow-lg shadow-indigo-500/30 group-active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20.2 6L3 11V4a1 1 0 0 1 1-1h15.2a1 1 0 0 1 1-1v2z"></path>
                                    <path d="M3 11v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V11H3z"></path>
                                    <path d="M3 11l17.2-5"></path>
                                    <path d="M8 11v11"></path>
                                    <path d="M13 11v11"></path>
                                </svg>
                            </div>
                            <div class="flex flex-col leading-none">
                                <span class="font-black text-white tracking-tighter text-xl uppercase italic underline decoration-indigo-500 decoration-4 underline-offset-2">MY<span class="text-indigo-400">SHOWS</span></span>
                                <span class="text-[8px] text-slate-400 font-bold tracking-[0.3em] uppercase">Watchlist Manager</span>
                            </div>
                        </Link>

                        <div class="hidden sm:-my-px sm:ms-10 sm:flex h-full">
                            <NavLink :href="route('shows.index')" :active="route().current('shows.*')"
                                class="inline-flex items-center px-1 pt-1 text-sm font-black text-slate-400 border-b-2 border-transparent hover:text-white transition-all uppercase tracking-widest">
                                🍿 Catálogo
                            </NavLink>
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center">
                        <div class="ms-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button type="button" class="flex items-center gap-3 px-4 py-2 rounded-full bg-slate-700/50 border border-slate-600 hover:border-indigo-500 hover:bg-slate-700 transition-all duration-300 group">
                                        <div class="h-7 w-7 rounded-lg bg-indigo-600 flex items-center justify-center text-[10px] font-black text-white uppercase shadow-lg">
                                            {{ $page.props.auth.user.name.substring(0,1) }}
                                        </div>
                                        <span class="text-xs font-black text-slate-200 group-hover:text-white">{{ $page.props.auth.user.name }}</span>
                                        <svg class="h-4 w-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                    </button>
                                </template>
                                <template #content>
                                    <div class="bg-slate-800 border border-slate-700 rounded-md shadow-xl">
                                        <div class="px-4 py-2 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] border-b border-slate-700 mb-1">Minha Conta</div>
                                        <DropdownLink :href="route('profile.edit')" class="text-slate-300 hover:bg-slate-700"> Perfil </DropdownLink>
                                        <div class="border-t border-slate-700 my-1"></div>
                                        <DropdownLink :href="route('logout')" method="post" as="button" class="text-red-400 font-bold hover:bg-red-900/20"> Sair </DropdownLink>
                                    </div>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-10 flex-grow relative">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-4xl h-96 bg-indigo-500/20 blur-[120px] pointer-events-none"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <slot />
            </div>
        </main>

        <footer class="py-12 border-t border-slate-800 bg-slate-800/50 flex-none mt-auto">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <div class="mb-4 flex justify-center gap-6">
                    <span class="text-slate-500 hover:text-indigo-400 cursor-pointer transition-colors text-xs font-bold uppercase tracking-widest">🎞️ Séries</span>
                    <span class="text-slate-500 hover:text-indigo-400 cursor-pointer transition-colors text-xs font-bold uppercase tracking-widest">🎬 Filmes</span>
                    <span class="text-slate-500 hover:text-indigo-400 cursor-pointer transition-colors text-xs font-bold uppercase tracking-widest">📈 Trending</span>
                </div>
                <p class="text-[10px] font-black text-slate-600 uppercase tracking-[0.4em]">
                    &copy; {{ new Date().getFullYear() }} MyShows — Powered by MovieData
                </p>
            </div>
        </footer>
    </div>
</template>