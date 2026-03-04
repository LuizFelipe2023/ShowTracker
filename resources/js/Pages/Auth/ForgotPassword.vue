<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Recuperar Senha" />

        <div class="mb-8">
            <h2 class="text-2xl font-black text-white tracking-tight uppercase italic">Recuperar <span class="text-indigo-500">Acesso</span></h2>
            <p class="mt-3 text-slate-400 text-[11px] font-medium leading-relaxed uppercase tracking-wider">
                Esqueceu sua senha? Sem problemas. Informe seu e-mail e enviaremos um link de redefinição para você escolher uma nova credencial.
            </p>
        </div>

        <div v-if="status" class="mb-6 font-bold text-xs text-emerald-400 bg-emerald-400/10 p-4 rounded-xl border border-emerald-400/20 leading-relaxed">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                {{ status }}
            </span>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <InputLabel for="email" value="E-mail de Cadastro" class="text-slate-300 font-bold uppercase text-[10px] tracking-widest" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-2 block w-full bg-slate-900/50 border-slate-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="seu@email.com"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="pt-2 flex flex-col gap-4">
                <PrimaryButton 
                    class="w-full justify-center py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black uppercase tracking-[0.2em] text-xs rounded-2xl shadow-lg shadow-indigo-500/20 transition-all active:scale-[0.98]" 
                    :class="{ 'opacity-25': form.processing }" 
                    :disabled="form.processing"
                >
                    Enviar Link de Recuperação
                </PrimaryButton>

                <div class="text-center">
                    <Link
                        :href="route('login')"
                        class="text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-white transition-colors"
                    >
                        ← Voltar para o <span class="text-indigo-400">Login</span>
                    </Link>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>