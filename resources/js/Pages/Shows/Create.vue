<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Form from './partials/Form.vue';
import { Link, Head } from '@inertiajs/vue3';
const props = defineProps({
    genres: Array,  
});

console.log('Create.vue - Genres recebidos:', props.genres); 
</script>

<template>
    <Head title="Novo Show" />

    <AuthenticatedLayout>
        <div class="max-w-4xl mx-auto px-4 py-10">
            
            <div class="mb-10">
                <nav class="flex items-center text-[10px] text-slate-500 mb-3 space-x-2 uppercase font-black tracking-[0.2em]">
                    <Link :href="route('shows.index')" class="hover:text-indigo-400 transition-colors">Catálogo</Link>
                    <span>/</span>
                    <span class="text-slate-600">Adicionar Título</span>
                </nav>
                <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic">
                    Novo <span class="text-indigo-500">Show</span>
                </h1>
                <p class="text-slate-400 text-sm mt-2 font-medium">Preencha os dados para catalogar sua nova maratona.</p>
            </div>

            <div class="bg-slate-800 shadow-2xl border border-slate-700 rounded-3xl overflow-hidden">
                <div class="p-8 md:p-12">
                    <Form
                        :submitUrl="route('shows.store')"
                        method="post"
                        :genres="genres"
                    />
                </div>
            </div>

            <div class="mt-8 flex justify-center">
                <Link 
                    :href="route('shows.index')" 
                    class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 hover:text-indigo-400 transition-all flex items-center gap-3 group"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Voltar para a biblioteca
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>