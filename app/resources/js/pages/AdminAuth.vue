<template>
    <div class="grid h-screen place-items-center bg-gray-100">
        <div class="w-full max-w-md p-6 space-y-8 bg-white rounded-lg shadow-md">

            <div class="flex justify-start">
                <button
                    @click="handleGoToHome"
                    class="flex items-center text-gray-600 hover:text-gray-800 transition-colors"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-medium">На сайт</span>
                </button>
            </div>

            <div class="text-center">
                <h2 class="mt-6 text-3xl font-bold tracking-tight text-gray-900">МедИнформСистем</h2>
                <h2 class="mt-6 text-ml font-bold tracking-tight text-gray-900">Вход в админ-панель</h2>
                <p class="mt-2 text-sm text-gray-600">Введите учетные данные для доступа</p>
            </div>

            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="grid gap-4">
                    <div class="grid gap-2">
                        <label for="email" class="text-gray-700 text-sm font-bold block">Email</label>
                        <input
                            id="email"
                            type="email"
                            v-model="form.email"
                            required
                            autofocus
                            autocomplete="email"
                            placeholder="admin@example.com"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        />
                    </div>

                    <div class="grid gap-2">
                        <label for="password" class="text-gray-700 text-sm font-bold block">Пароль</label>
                        <input
                            id="password"
                            type="password"
                            v-model="form.password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        />
                    </div>

                    <button
                        type="submit"
                        class="mt-4 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        :disabled="form.processing"
                    >
                        <span v-if="form.processing" class="inline-flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V1a1 1 0 110 2h-3a1 1 0 110 2h3a1 1 0 110 2H8a8 8 0 01-8 8z"></path>
                            </svg>
                            Вход...
                        </span>
                        <span v-else>Войти</span>
                    </button>
                </div>

                <div v-if="hasErrors" class="text-red-500 text-sm">
                    <p v-for="(error, field) in form.errors" :key="field">{{ error }}</p>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useForm, router } from '@inertiajs/vue3';
import { computed } from 'vue';

const form = useForm({
    email: '',
    password: '',
});

const hasErrors = computed(() => Object.keys(form.errors).length > 0);

const handleGoToHome = () => {
    router.get(route('home'));
};
const submit = () => {
    form.post(route('login'),{
        onSuccess: (response) => {
            router.visit(response.redirect);
        },
        onError: (errors) => {
            form.clearErrors().setError(errors);
        },
        onFinish: () => {
            form.reset('password');
        }
    });
};
</script>
