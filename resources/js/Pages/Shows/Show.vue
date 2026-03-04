<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, Head } from '@inertiajs/vue3';

const props = defineProps({
    show: Object,
});

const formatDate = (date) => {
    return date ? new Date(date).toLocaleDateString('pt-BR', { year: 'numeric', month: 'long', day: 'numeric' }) : 'N/A';
};

const statusMap = {
    'finished': { label: 'Finalizado', class: 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' },
    'watching': { label: 'Assistindo', class: 'bg-amber-500/10 text-amber-400 border-amber-500/20' },
    'to watch': { label: 'Planejado', class: 'bg-slate-700 text-slate-400 border-slate-600' }
};
</script>

<template>
    <Head :title="show.title" />

    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6 border-b border-slate-800 pb-8">
                <div>
                    <nav class="flex text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-3">
                        <Link :href="route('shows.index')" class="hover:text-indigo-400 transition-colors">Biblioteca</Link>
                        <span class="mx-2 text-slate-700">/</span>
                        <span class="text-slate-600">Ficha Técnica</span>
                    </nav>
                    <h1 class="text-5xl font-black text-white tracking-tighter uppercase italic flex flex-wrap items-center gap-4">
                        {{ show.title }}
                        <span v-if="show.rating" class="text-amber-400 text-2xl font-black bg-amber-400/10 px-3 py-1 rounded-xl border border-amber-400/20 not-italic tracking-normal">
                            ★ {{ show.rating }}
                        </span>
                    </h1>
                </div>

                <div class="flex items-center gap-4">
                    <Link :href="route('shows.edit', show.id)"
                        class="inline-flex items-center px-8 py-3 bg-indigo-600 rounded-xl font-black text-[10px] text-white uppercase tracking-[0.2em] hover:bg-indigo-500 transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                        Editar Dados
                    </Link>
                    <Link :href="route('shows.index')"
                        class="text-[10px] font-black text-slate-500 hover:text-white transition-colors uppercase tracking-[0.2em] flex items-center gap-2 group">
                        <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        Voltar
                    </Link>
                </div>
            </div>

            <div class="bg-slate-800 rounded-[2.5rem] shadow-2xl border border-slate-700 overflow-hidden">
                <div class="md:flex">
                    
                    <div class="md:w-1/3 lg:w-1/4 relative group overflow-hidden bg-slate-900">
                        <img v-if="show.cover_image" :src="`/storage/${show.cover_image}`"
                            class="w-full h-full object-cover aspect-[2/3] md:aspect-auto group-hover:scale-105 transition-transform duration-700 opacity-90 group-hover:opacity-100" :alt="show.title" />
                        <div v-else
                            class="w-full h-full min-h-[400px] flex flex-col items-center justify-center text-slate-700">
                            <svg class="w-16 h-16 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            <span class="text-[10px] font-black uppercase tracking-widest">Poster Indisponível</span>
                        </div>
                    </div>

                    <div class="md:w-2/3 lg:w-3/4 p-10 md:p-16 space-y-12">
                        <div>
                            <div class="flex flex-wrap items-center gap-6 mb-8">
                                <span :class="[
                                    'px-4 py-1.5 text-[10px] font-black uppercase rounded-full tracking-[0.15em] border',
                                    statusMap[show.status]?.class || 'bg-slate-700 text-slate-400 border-slate-600'
                                ]">
                                    ● {{ statusMap[show.status]?.label || show.status }}
                                </span>
                                <span class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    Estreia: <span class="text-slate-300">{{ formatDate(show.release_date) }}</span>
                                </span>
                            </div>

                            <h2 class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.3em] mb-6">Sinopse da Obra</h2>
                            <p class="text-slate-300 leading-relaxed text-xl font-medium italic border-l-4 border-indigo-500/30 pl-8 py-2">
                                "{{ show.description || 'Este título ainda não possui uma sinopse detalhada em sua biblioteca.' }}"
                            </p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-12 border-t border-slate-700/50">
                            <div class="bg-slate-900/50 p-6 rounded-2xl border border-slate-700/50 flex items-center gap-5">
                                <div class="p-3 bg-slate-800 rounded-xl text-slate-500 border border-slate-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                </div>
                                <div>
                                    <p class="text-[9px] text-slate-500 font-black uppercase tracking-widest mb-1">Catalogado em</p>
                                    <p class="text-sm font-bold text-slate-200">{{ formatDate(show.created_at) }}</p>
                                </div>
                            </div>
                            
                            <div class="bg-slate-900/50 p-6 rounded-2xl border border-slate-700/50 flex items-center gap-5">
                                <div class="p-3 bg-slate-800 rounded-xl text-slate-500 border border-slate-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2zM4 18l16-12M20 18L4 6" /></svg>
                                </div>
                                <div>
                                    <p class="text-[9px] text-slate-500 font-black uppercase tracking-widest mb-1">Sincronizado</p>
                                    <p class="text-sm font-bold text-slate-200">{{ formatDate(show.updated_at) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 text-center sm:hidden">
                <Link :href="route('shows.index')"
                    class="text-[10px] font-black text-slate-500 hover:text-white transition-colors uppercase tracking-[0.2em] inline-flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Voltar para a lista
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>