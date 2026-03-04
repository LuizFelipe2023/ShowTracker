<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Acessar Minha Conta" />

        <div class="mb-8">
            <h2 class="text-2xl font-black text-white tracking-tight uppercase italic">Login</h2>
            <p class="text-slate-400 text-xs font-medium uppercase tracking-widest mt-1">Bem-vindo de volta ao MyShows</p>
        </div>

        <div v-if="status" class="mb-4 font-bold text-sm text-emerald-400 bg-emerald-400/10 p-3 rounded-lg border border-emerald-400/20">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <InputLabel for="email" value="Seu E-mail" class="text-slate-300 font-bold uppercase text-[10px] tracking-widest" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-2 block w-full bg-slate-900/50 border-slate-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="exemplo@email.com"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="password" value="Sua Senha" class="text-slate-300 font-bold uppercase text-[10px] tracking-widest" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-2 block w-full bg-slate-900/50 border-slate-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center group cursor-pointer">
                    <Checkbox name="remember" v-model:checked="form.remember" class="rounded border-slate-700 bg-slate-900 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                    <span class="ms-2 text-xs font-bold text-slate-500 group-hover:text-slate-300 transition-colors uppercase tracking-widest">Lembrar de mim</span>
                </label>

                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-indigo-400 transition-colors"
                >
                    Esqueceu a senha?
                </Link>
            </div>

            <div class="pt-2">
                <PrimaryButton 
                    class="w-full justify-center py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black uppercase tracking-[0.2em] text-xs rounded-2xl shadow-lg shadow-indigo-500/20 transition-all active:scale-[0.98]" 
                    :class="{ 'opacity-25': form.processing }" 
                    :disabled="form.processing"
                >
                    Entrar no Sistema
                </PrimaryButton>
            </div>
            
            <div class="text-center mt-6">
                <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">
                    Não tem uma conta? 
                    <Link :href="route('register')" class="text-indigo-500 hover:text-indigo-400 font-black ml-1">Criar agora</Link>
                </p>
            </div>
        </form>
    </GuestLayout>
</template>