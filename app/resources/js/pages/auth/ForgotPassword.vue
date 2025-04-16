<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps<{
    status?: string;
}>();

const form = useForm({
    email: '',
});

const processing = ref(false);

const submit = () => {
    processing.value = true;
    form.post(route('password.email'), {
        onFinish: () => processing.value = false,
        onError: () => processing.value = false,
    });
};
</script>

<template>
    <div class="grid h-screen place-items-center bg-gray-100">
        <div class="w-full max-w-md p-6 space-y-8 bg-white rounded-lg shadow-md">
            <Head title="Forgot password" />

            <div class="text-center">
                <h2 class="mt-6 text-3xl font-bold tracking-tight text-gray-900">Восстановление пароля</h2>
                <p class="mt-2 text-sm text-gray-600">Введите ваш email для получения ссылки сброса пароля</p>
            </div>

            <div v-if="status" class="mb-4 p-3 text-center text-sm text-green-600 bg-green-50 rounded-lg">
                {{ status }}
            </div>

            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="grid gap-2">
                    <label for="email" class="text-gray-700 text-sm font-bold block mb-2">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        autocomplete="off"
                        v-model="form.email"
                        placeholder="email@example.com"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        autofocus
                    />
                    <p v-if="form.errors.email" class="text-red-500 text-xs italic">{{ form.errors.email }}</p>
                </div>

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
                    <span v-else>Отправить ссылку для сброса</span>
                </button>

                <div class="text-center text-sm text-gray-500">
                    Вернуться к
                    <Link :href="route('login')" class="text-blue-500 hover:underline">входу в систему</Link>
                </div>
            </form>
        </div>
    </div>
</template>
