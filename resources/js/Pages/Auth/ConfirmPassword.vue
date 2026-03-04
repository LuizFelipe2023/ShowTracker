<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Confirmar Senha" />

        <div class="mb-8">
            <div class="flex items-center gap-2 mb-2">
                <div class="p-1.5 bg-amber-500/10 rounded-lg border border-amber-500/20">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h2 class="text-xl font-black text-white tracking-tight uppercase italic">Área <span class="text-indigo-500">Restrita</span></h2>
            </div>
            <p class="text-slate-400 text-[11px] font-medium leading-relaxed uppercase tracking-wider">
                Esta é uma zona segura. Por favor, confirme sua senha antes de continuar para proteger seus dados.
            </p>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <InputLabel for="password" value="Sua Senha" class="text-slate-300 font-bold uppercase text-[10px] tracking-widest" />
                
                <TextInput
                    id="password"
                    type="password"
                    class="mt-2 block w-full bg-slate-900/50 border-slate-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    autofocus
                    placeholder="••••••••"
                />
                
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="pt-2">
                <PrimaryButton 
                    class="w-full justify-center py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black uppercase tracking-[0.2em] text-xs rounded-2xl shadow-lg shadow-indigo-500/20 transition-all active:scale-[0.98]" 
                    :class="{ 'opacity-25': form.processing }" 
                    :disabled="form.processing"
                >
                    Confirmar Identidade
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>