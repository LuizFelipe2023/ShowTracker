<script setup>
import { ref, onMounted, onBeforeUnmount, nextTick } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import flatpickr from "flatpickr";
import "flatpickr/dist/themes/dark.css";
import { Portuguese } from "flatpickr/dist/l10n/pt.js";

import Choices from 'choices.js';
import 'choices.js/public/assets/styles/choices.min.css';

const props = defineProps({
    show: Object,
    genres: Array,
    submitUrl: String,
    method: String,
});

const dateInput = ref(null);
const genresInput = ref(null);
let choicesInstance = null;

const form = useForm({
    title: props.show?.title ?? '',
    description: props.show?.description ?? '',
    release_date: props.show?.release_date ?? '',
    rating: props.show?.rating ?? '',
    status: props.show?.status ?? 'watching',
    cover_image: null,
    genre_ids: props.show?.genres ? props.show.genres.map(g => g.id) : [],
    _method: props.method.toUpperCase(),
});

const imagePreview = ref(props.show?.cover_image ? `/storage/${props.show.cover_image}` : null);

const handleFileChange = (e) => {
    const file = e.target.files[0];
    form.cover_image = file;
    if (file) imagePreview.value = URL.createObjectURL(file);
};

onMounted(async () => {
    await nextTick();

    if (genresInput.value) {
        choicesInstance = new Choices(genresInput.value, {
            removeItemButton: true,
            placeholder: true,
            placeholderValue: 'Selecione os gêneros',
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

        if (form.genre_ids.length > 0) {
            choicesInstance.setChoiceByValue(form.genre_ids.map(String));
        }

        genresInput.value.addEventListener('change', () => {
            form.genre_ids = choicesInstance.getValue(true);
        });
    }

    if (dateInput.value) {
        flatpickr(dateInput.value, {
            locale: Portuguese,
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d \\d\\e F \\d\\e Y",
            disableMobile: "true",
        });
    }
});

onBeforeUnmount(() => {
    if (choicesInstance) choicesInstance.destroy();
});

const submit = () => {
    form.post(props.submitUrl, { forceFormData: true, preserveScroll: true });
};

import '@/../css/choices-custom.css';
</script>

<template>
    <div class="w-full">
        
        <form @submit.prevent="submit" class="space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black uppercase text-slate-500 mb-2 tracking-[0.2em]">Título</label>
                    <input v-model="form.title" type="text" 
                        class="w-full rounded-xl border-slate-700 bg-slate-900 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-inner px-4 py-3.5 placeholder:text-slate-600 transition-all" 
                        placeholder="Ex: The Last of Us" />
                </div>

                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black uppercase text-slate-500 mb-2 tracking-[0.2em]">Gêneros</label>
                    <select ref="genresInput" multiple>
                        <option value="">Selecione os gêneros</option>
                        <option v-for="genre in genres" :key="genre.id" :value="genre.id">
                            {{ genre.name }}
                        </option>
                    </select>
                    <p v-if="form.errors.genre_ids" class="mt-2 text-xs text-red-400 font-bold uppercase">{{ form.errors.genre_ids }}</p>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-500 mb-2 tracking-[0.2em]">Status</label>
                    <select v-model="form.status" 
                        class="w-full rounded-xl border-slate-700 bg-slate-900 text-white focus:ring-2 focus:ring-indigo-500 shadow-inner py-3.5 px-4 font-bold">
                        <option value="to watch">⏳ Planejo Assistir</option>
                        <option value="watching">👀 Assistindo</option>
                        <option value="finished">✅ Finalizado</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-500 mb-2 tracking-[0.2em]">Nota</label>
                    <input type="number" step="0.1" min="0" max="10" v-model="form.rating" 
                        class="w-full rounded-xl border-slate-700 bg-slate-900 text-white shadow-inner py-3.5 px-4 focus:ring-2 focus:ring-indigo-500 font-bold" 
                        placeholder="0-10" />
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase text-slate-500 mb-2 tracking-[0.2em]">Sinopse</label>
                <textarea v-model="form.description" rows="4" 
                    class="w-full rounded-xl border-slate-700 bg-slate-900 text-white focus:ring-2 focus:ring-indigo-500 shadow-inner px-4 py-3.5 transition-all"
                    placeholder="Descrição do show..."></textarea>
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase text-slate-500 mb-2 tracking-[0.2em]">Lançamento</label>
                <input ref="dateInput" v-model="form.release_date" type="text" 
                    class="w-full md:w-1/2 rounded-xl border-slate-700 bg-slate-900 text-white shadow-inner py-3.5 px-4 focus:ring-2 focus:ring-indigo-500 transition-all uppercase text-xs font-bold" 
                    placeholder="Selecione uma data" />
            </div>

            <div class="bg-slate-900/50 p-6 rounded-2xl border-2 border-dashed border-slate-700/50">
                <label class="block text-[10px] font-black uppercase text-slate-500 mb-4 tracking-[0.2em]">Poster / Capa</label>
                <div class="flex items-center gap-8">
                    <div class="w-28 h-40 bg-slate-800 rounded-xl overflow-hidden border border-slate-700 shadow-2xl flex-shrink-0 flex items-center justify-center">
                        <img v-if="imagePreview" :src="imagePreview" class="w-full h-full object-cover" />
                        <div v-else class="w-full h-full flex items-center justify-center opacity-20">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <input type="file" @change="handleFileChange" accept="image/*" 
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 cursor-pointer" />
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-6 pt-8 border-t border-slate-800/50">
                <Link :href="route('shows.index')" 
                    class="text-[10px] font-black uppercase text-slate-500 hover:text-white transition-colors">
                    Cancelar
                </Link>
                <button type="submit" :disabled="form.processing" 
                    class="px-10 py-4 bg-indigo-600 text-white rounded-xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-indigo-500 active:scale-95 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                    {{ form.processing ? 'Processando...' : 'Salvar Título' }}
                </button>
            </div>
        </form>
    </div>
</template>