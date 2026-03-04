<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Redefinir Senha" />

        <div class="mb-8">
            <h2 class="text-2xl font-black text-white tracking-tight uppercase italic">Nova <span class="text-indigo-500">Senha</span></h2>
            <p class="text-slate-400 text-xs font-medium uppercase tracking-widest mt-1">Quase lá! Escolha sua nova credencial de acesso</p>
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <div>
                <InputLabel for="email" value="E-mail de Confirmação" class="text-slate-300 font-bold uppercase text-[10px] tracking-widest" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-2 block w-full bg-slate-900/50 border-slate-700 text-slate-400 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl opacity-70"
                    v-model="form.email"
                    required
                    readonly
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="password" value="Nova Senha" class="text-slate-300 font-bold uppercase text-[10px] tracking-widest" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-2 block w-full bg-slate-900/50 border-slate-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl"
                    v-model="form.password"
                    required
                    autofocus
                    autocomplete="new-password"
                    placeholder="Mínimo 8 dígitos"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div>
                <InputLabel for="password_confirmation" value="Repetir Nova Senha" class="text-slate-300 font-bold uppercase text-[10px] tracking-widest" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-2 block w-full bg-slate-900/50 border-slate-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Confirme sua senha"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="pt-4">
                <PrimaryButton 
                    class="w-full justify-center py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black uppercase tracking-[0.2em] text-xs rounded-2xl shadow-lg shadow-indigo-500/20 transition-all active:scale-[0.98]" 
                    :class="{ 'opacity-25': form.processing }" 
                    :disabled="form.processing"
                >
                    Redefinir e Acessar
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>