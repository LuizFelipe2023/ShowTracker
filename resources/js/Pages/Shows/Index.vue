<script setup>
import { ref, watch, onMounted, onBeforeUnmount, nextTick } from 'vue';
import { router, Link, usePage, Head } from '@inertiajs/vue3';
import { pickBy, throttle } from 'lodash';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import Choices from 'choices.js';
import 'choices.js/public/assets/styles/choices.min.css';

import '@/../css/choices-custom.css';

const props = defineProps({
    shows: Object,
    filters: Object,
    genres: Array,
});

const page = usePage();
const genresInput = ref(null);
let choicesInstance = null;

const params = ref({
    status: props.filters?.status || '',
    genre_ids: props.filters?.genre_ids || [], 
    sort: props.filters?.sort || 'title',
    direction: props.filters?.direction || 'asc',
});

const showSuccessAlert = ref(false);

onMounted(async () => {
    await nextTick();
    
    if (genresInput.value) {
        choicesInstance = new Choices(genresInput.value, {
            removeItemButton: true,
            placeholder: true,
            placeholderValue: 'Todos os Gêneros',
            searchPlaceholderValue: 'Pesquisar...',
            noResultsText: 'Nenhum gênero encontrado',
            noChoicesText: 'Nenhum gênero disponível',
            itemSelectText: '',
            allowHTML: true,
            shouldSort: false,
            classNames: {
                containerOuter: 'choices',
                containerInner: 'choices__inner',
                input: 'choices__input',
                inputCloned: 'choices__input--cloned',
                list: 'choices__list',
                listItems: 'choices__list--multiple',
                listSingle: 'choices__list--single',
                listDropdown: 'choices__list--dropdown',
                item: 'choices__item',
                itemSelectable: 'choices__item--selectable',
                itemDisabled: 'choices__item--disabled',
                itemChoice: 'choices__item--choice',
                group: 'choices__group',
                groupHeading: 'choices__heading',
                button: 'choices__button',
                activeState: 'is-active',
                focusState: 'is-focused',
                openState: 'is-open',
                disabledState: 'is-disabled',
                highlightedState: 'is-highlighted',
                selectedState: 'is-selected',
                flippedState: 'is-flipped',
                selected: 'is-selected',
                highlighted: 'is-highlighted',
            }
        });

        if (params.value.genre_ids.length > 0) {
            choicesInstance.setChoiceByValue(params.value.genre_ids.map(String));
        }

        genresInput.value.addEventListener('change', () => {
            params.value.genre_ids = choicesInstance.getValue(true);
        });
    }
});

onBeforeUnmount(() => {
    if (choicesInstance) {
        choicesInstance.destroy();
        choicesInstance = null;
    }
});

watch(() => page.props.flash?.success, (message) => {
    if (message) {
        showSuccessAlert.value = true;
        setTimeout(() => { showSuccessAlert.value = false; }, 5000);
    }
}, { immediate: true });

watch(params, throttle((value) => {
    router.get(route('shows.index'), pickBy(value), {
        preserveState: true,
        replace: true,
    });
}, 300), { deep: true });
</script>

<template>
    <Head title="Meus Shows" />

    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            
            <transition enter-active-class="transform transition ease-out duration-300" enter-from-class="translate-y-2 opacity-0" enter-to-class="translate-y-0 opacity-100" leave-active-class="transition ease-in duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
                <div v-if="page.props.flash?.success && showSuccessAlert" class="mb-8 flex items-center p-4 text-emerald-100 bg-emerald-600 rounded-2xl shadow-lg border-b-4 border-emerald-700">
                    <div class="ml-3 text-sm font-black uppercase tracking-widest">{{ page.props.flash.success }}</div>
                    <button @click="showSuccessAlert = false" class="ml-auto hover:scale-110">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </transition>

            <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-6 border-b border-slate-800 pb-8">
                <div>
                    <h1 class="text-4xl font-black text-white tracking-tight italic uppercase">Sua <span class="text-indigo-400">Biblioteca</span></h1>
                    <p class="text-slate-400 mt-2 font-medium">Gerencie seus seriados e progresso de visualização.</p>
                </div>
                <Link :href="route('shows.create')" class="px-8 py-3.5 bg-indigo-500 rounded-xl font-black text-xs text-white uppercase tracking-widest hover:bg-indigo-400 shadow-lg active:scale-95 transition-all">+ Adicionar Novo</Link>
            </div>

            <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 mb-8 flex flex-wrap gap-6 items-end shadow-xl">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 tracking-widest">Status</label>
                    <select v-model="params.status" class="w-full rounded-lg border-slate-700 bg-slate-900 text-slate-200 focus:ring-indigo-500 py-2.5 px-4 font-bold text-sm transition-all">
                        <option value="">Todos os Status</option>
                        <option value="to watch">⏳ Planejo Assistir</option>
                        <option value="watching">👀 Assistindo</option>
                        <option value="finished">✅ Finalizado</option>
                    </select>
                </div>

                <div class="flex-[2] min-w-[250px]">
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 tracking-widest">Gêneros</label>
                    <select ref="genresInput" multiple>
                        <option value="">Todos os Gêneros</option>
                        <option v-for="genre in genres" :key="genre.id" :value="genre.id">
                            {{ genre.name }}
                        </option>
                    </select>
                </div>

                <div class="flex-1 min-w-[180px]">
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 tracking-widest">Ordenar Por</label>
                    <select v-model="params.sort" class="w-full rounded-lg border-slate-700 bg-slate-900 text-slate-200 focus:ring-indigo-500 py-2.5 px-4 font-bold text-sm transition-all">
                        <option value="title">Título</option>
                        <option value="rating">Sua Nota</option>
                        <option value="created_at">Data de Adição</option>
                    </select>
                </div>

                <button @click="params.direction = params.direction === 'asc' ? 'desc' : 'asc'"
                    class="h-[46px] px-4 bg-slate-700 border border-slate-600 hover:bg-slate-600 text-slate-200 rounded-lg transition-all font-black text-[10px] uppercase tracking-widest flex items-center gap-2">
                    <svg :class="{'rotate-180': params.direction === 'desc'}" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" /></svg>
                    {{ params.direction === 'asc' ? 'Asc' : 'Desc' }}
                </button>
            </div>

            <div class="bg-slate-800 overflow-hidden shadow-2xl border border-slate-700 rounded-2xl">
                <table class="min-w-full divide-y divide-slate-700">
                    <thead class="bg-slate-900/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">Título</th>
                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 text-right text-[10px] font-black text-slate-500 uppercase tracking-widest">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700 bg-slate-800">
                        <tr v-for="show in shows.data" :key="show.id" class="hover:bg-slate-700/50 transition-colors group">
                            <td class="px-6 py-5">
                                <Link :href="route('shows.show', show.id)" class="block">
                                    <div class="text-sm font-bold text-white group-hover:text-indigo-400 transition-colors">{{ show.title }}</div>
                                    <div class="flex gap-1 mt-1 flex-wrap">
                                        <span v-for="genre in show.genres" :key="genre.id" class="text-[8px] text-slate-500 font-bold uppercase border border-slate-700 px-1.5 py-0.5 rounded">
                                            {{ genre.name }}
                                        </span>
                                    </div>
                                </Link>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span :class="{
                                    'px-3 py-1 text-[9px] rounded font-black uppercase tracking-widest inline-block': true,
                                    'bg-emerald-900/40 text-emerald-400 border border-emerald-500/20': show.status === 'finished',
                                    'bg-amber-900/40 text-amber-400 border border-amber-500/20': show.status === 'watching',
                                    'bg-slate-900 text-slate-500 border border-slate-700': show.status === 'to watch'
                                }">
                                    {{ show.status === 'to watch' ? 'Planejado' : (show.status === 'watching' ? 'Assistindo' : 'Finalizado') }}
                                </span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-right text-sm">
                                <div class="flex justify-end gap-2">
                                    <Link :href="route('shows.edit', show.id)" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-lg transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </Link>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>