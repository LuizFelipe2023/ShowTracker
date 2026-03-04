<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Form from './partials/Form.vue';
import { Link, Head } from '@inertiajs/vue3';

const props = defineProps({
    show: Object,
    genres: Array, 
});
</script>

<template>
    <Head :title="`Editar: ${show.title}`" />

    <AuthenticatedLayout>
        <div class="max-w-4xl mx-auto px-4 py-10">
            
            <div class="mb-10">
                <nav class="flex items-center text-[10px] text-slate-500 mb-3 space-x-2 uppercase font-black tracking-[0.2em]">
                    <Link :href="route('shows.index')" class="hover:text-indigo-400 transition-colors">Catálogo</Link>
                    <span>/</span>
                    <span class="text-slate-600">Editar Título</span>
                </nav>

                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                    <div class="flex items-center gap-5">
                        <div v-if="show.cover_image" class="w-14 h-20 rounded-xl shadow-2xl overflow-hidden border border-white/10 bg-slate-900 flex-shrink-0">
                            <img :src="`/storage/${show.cover_image}`" class="w-full h-full object-cover opacity-80 transition-opacity" alt="Capa atual">
                        </div>
                        <div>
                            <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic">
                                Editar <span class="text-indigo-500">Show</span>
                            </h1>
                            <p class="text-slate-400 text-sm mt-1 font-medium italic">
                                Modificando: <span class="text-slate-200 font-bold not-italic">{{ show.title }}</span>
                            </p>
                        </div>
                    </div>

                    <Link 
                        :href="route('shows.index')" 
                        class="hidden sm:flex items-center text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-white transition-all group"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 transform group-hover:-translate-x-1 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Voltar ao Catálogo
                    </Link>
                </div>
            </div>

            <div class="bg-slate-800 shadow-2xl border border-slate-700 rounded-3xl relative overflow-hidden">
                <div class="h-1.5 bg-gradient-to-r from-indigo-600 to-indigo-400 w-full"></div>
                
                <div class="p-8 md:p-12">
                    <Form
                        :show="show"
                        :genres="genres" 
                        :submitUrl="route('shows.update', show.id)"
                        method="put"
                    />
                </div>
            </div>

            <div class="mt-8 flex flex-col sm:flex-row justify-between items-center gap-4 px-4">
                <p class="text-[10px] text-slate-600 font-black uppercase tracking-[0.2em]">
                    SISTEMA ID: #{{ show.id }} — SINCRO: {{ new Date(show.updated_at).toLocaleDateString() }}
                </p>
                
                <Link 
                    :href="route('shows.index')" 
                    class="text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-indigo-400 transition-colors sm:hidden"
                >
                    ← Voltar
                </Link>
            </div>

        </div>
    </AuthenticatedLayout>
</template>