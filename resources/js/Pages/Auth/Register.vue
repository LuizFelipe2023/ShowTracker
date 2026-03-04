<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Criar Conta" />

        <div class="mb-8">
            <h2 class="text-2xl font-black text-white tracking-tight uppercase italic">Criar <span class="text-indigo-500">Conta</span></h2>
            <p class="text-slate-400 text-xs font-medium uppercase tracking-widest mt-1">Junte-se à maior watchlist pessoal</p>
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <div>
                <InputLabel for="name" value="Nome Completo" class="text-slate-300 font-bold uppercase text-[10px] tracking-widest" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-2 block w-full bg-slate-900/50 border-slate-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Como devemos te chamar?"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="E-mail" class="text-slate-300 font-bold uppercase text-[10px] tracking-widest" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-2 block w-full bg-slate-900/50 border-slate-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl"
                    v-model="form.email"
                    required
                    autocomplete="username"
                    placeholder="seu@email.com"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="password" value="Senha" class="text-slate-300 font-bold uppercase text-[10px] tracking-widest" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-2 block w-full bg-slate-900/50 border-slate-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                    placeholder="Mínimo 8 caracteres"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div>
                <InputLabel for="password_confirmation" value="Confirmar Senha" class="text-slate-300 font-bold uppercase text-[10px] tracking-widest" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-2 block w-full bg-slate-900/50 border-slate-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Repita a senha"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="pt-4 flex flex-col gap-4">
                <PrimaryButton 
                    class="w-full justify-center py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black uppercase tracking-[0.2em] text-xs rounded-2xl shadow-lg shadow-indigo-500/20 transition-all active:scale-[0.98]" 
                    :class="{ 'opacity-25': form.processing }" 
                    :disabled="form.processing"
                >
                    Finalizar Cadastro
                </PrimaryButton>

                <div class="text-center">
                    <Link
                        :href="route('login')"
                        class="text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-white transition-colors"
                    >
                        Já possui cadastro? <span class="text-indigo-400">Faça login</span>
                    </Link>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>