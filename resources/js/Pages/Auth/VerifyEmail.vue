<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <GuestLayout>
        <Head title="Verificação de E-mail" />

        <div class="mb-8">
            <h2 class="text-2xl font-black text-white tracking-tight uppercase italic">Quase <span class="text-indigo-500">Lá!</span></h2>
            <p class="mt-3 text-slate-400 text-[11px] font-medium leading-relaxed uppercase tracking-wider">
                Obrigado por se cadastrar! Antes de começar, você poderia verificar seu e-mail clicando no link que acabamos de enviar? Se não recebeu, podemos enviar outro sem problemas.
            </p>
        </div>

        <div v-if="verificationLinkSent" class="mb-6 font-bold text-xs text-emerald-400 bg-emerald-400/10 p-4 rounded-xl border border-emerald-400/20 leading-relaxed">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                Um novo link de verificação foi enviado para o seu e-mail.
            </span>
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex flex-col gap-4">
                <PrimaryButton 
                    class="w-full justify-center py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black uppercase tracking-[0.2em] text-xs rounded-2xl shadow-lg shadow-indigo-500/20 transition-all active:scale-[0.98]" 
                    :class="{ 'opacity-25': form.processing }" 
                    :disabled="form.processing"
                >
                    Reenviar E-mail de Verificação
                </PrimaryButton>

                <div class="flex justify-center mt-2">
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-red-400 transition-colors"
                    >
                        Sair da Conta
                    </Link>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>