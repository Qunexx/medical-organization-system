<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    password: '',
});

const processing = ref(false);

const submit = () => {
    processing.value = true;
    form.post(route('password.confirm'), {
        onFinish: () => {
            form.reset();
            processing.value = false;
        },
        onError: () => {
            processing.value = false;
        },
    });
};
</script>

<template>
    <div class="grid h-screen place-items-center bg-gray-100">
        <div class="w-full max-w-md p-6 space-y-8 bg-white rounded-lg shadow-md">
            <Head title="Confirm password" />

            <div class="text-center">
                <h2 class="mt-6 text-3xl font-bold tracking-tight text-gray-900">Подтверждение пароля</h2>
                <p class="mt-2 text-sm text-gray-600">Это защищенная зона приложения. Пожалуйста, подтвердите ваш пароль для продолжения.</p>
            </div>

            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="grid gap-2">
                    <label for="password" class="text-gray-700 text-sm font-bold block mb-2">Пароль</label>
                    <input
                        id="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        v-model="form.password"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        autofocus
                        placeholder="Введите ваш пароль"
                    />
                    <p v-if="form.errors.password" class="text-red-500 text-xs italic">{{ form.errors.password }}</p>
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
                        Проверка...
                    </span>
                    <span v-else>Подтвердить пароль</span>
                </button>
            </form>
        </div>
    </div>
</template>
