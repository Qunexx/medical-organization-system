<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps<{
    status?: string;
}>();

const form = useForm({});
const processing = ref(false);

const submit = () => {
    processing.value = true;
    form.post(route('verification.send'), {
        onFinish: () => processing.value = false,
        onError: () => processing.value = false,
    });
};
</script>

<template>
    <div class="grid h-screen place-items-center bg-gray-100">
        <div class="w-full max-w-md p-6 space-y-8 bg-white rounded-lg shadow-md">
            <Head title="Email verification" />

            <div class="text-center">
                <h2 class="mt-6 text-3xl font-bold tracking-tight text-gray-900">Подтверждение email</h2>
                <p class="mt-2 text-sm text-gray-600">Пожалуйста, подтвердите ваш email адрес, перейдя по ссылке в письме</p>
            </div>

            <div v-if="status === 'verification-link-sent'" class="mb-4 p-3 text-center text-sm text-green-600 bg-green-50 rounded-lg">
                Новая ссылка для подтверждения была отправлена на ваш email
            </div>

            <form @submit.prevent="submit" class="flex flex-col gap-6 text-center">
                <button
                    type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    :disabled="processing"
                >
                    <span v-if="processing" class="inline-flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V1a1 1 0 110 2h-3a1 1 0 110 2h3a1 1 0 110 2H8a8 8 0 01-8 8z"></path>
                        </svg>
                        Отправка...
                    </span>
                    <span v-else>Отправить письмо повторно</span>
                </button>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="text-sm text-blue-500 hover:underline"
                >
                    Выйти из аккаунта
                </Link>
            </form>
        </div>
    </div>
</template>
