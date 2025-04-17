<script setup lang="ts">
import {Head, useForm, Link, router} from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const processing = ref(false);

const submit = () => {
    processing.value = true;
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
            processing.value = false;
        },
        onError: () => {
            processing.value = false;
        },
    });
};

const handleGoToHome = () => {
    router.visit(route('home'));
};
</script>

<template>

    <div class="grid h-screen place-items-center bg-gray-100">
        <div class="w-full max-w-md p-6 space-y-8 bg-white rounded-lg shadow-md">
            <Head title="Log in" />

            <div class="text-center">
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
                <h2 class="mt-6 text-3xl font-bold tracking-tight text-gray-900">Авторизуйтесь в свой аккаунт</h2>
                <p class="mt-2 text-sm text-gray-600">Введите свой email и пароль для входа</p>
            </div>

            <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="grid gap-6">
                    <div class="grid gap-2">
                        <label for="email" class="text-gray-700 text-sm font-bold block mb-2">Email address</label>
                        <input
                            id="email"
                            type="email"
                            required
                            autofocus
                            tabindex="1"
                            autocomplete="email"
                            v-model="form.email"
                            placeholder="email@example.com"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        />
                        <p v-if="form.errors.email" class="text-red-500 text-xs italic">{{ form.errors.email }}</p>
                    </div>

                    <div class="grid gap-2">
                        <div class="flex items-center justify-between">
                            <label for="password" class="text-gray-700 text-sm font-bold block mb-2">Password</label>
                            <Link v-if="canResetPassword" :href="route('password.request')" class="text-sm text-blue-500 hover:underline" :tabindex="5">
                                Забыли пароль?
                            </Link>
                        </div>
                        <input
                            id="password"
                            type="password"
                            required
                            tabindex="2"
                            autocomplete="current-password"
                            v-model="form.password"
                            placeholder="Пароль"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        />
                        <p v-if="form.errors.password" class="text-red-500 text-xs italic">{{ form.errors.password }}</p>
                    </div>

                    <div class="flex items-center justify-between" :tabindex="3">
                        <label for="remember" class="flex items-center space-x-2">
                            <input id="remember" type="checkbox" v-model="form.remember" tabindex="4" class="form-checkbox h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500" />
                            <span class="text-gray-700 text-sm">Запомнить меня</span>
                        </label>
                    </div>

                    <button type="submit" class="mt-4 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" :tabindex="4" :disabled="processing.value">
                        <span v-if="processing.value" class="inline-flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V1a1 1 0 110 2h-3a1 1 0 110 2h3a1 1 0 110 2H8a8 8 0 01-8 8z"></path>
                            </svg>
                            Вход...
                        </span>
                        <span v-else>Войти</span>
                    </button>
                </div>

                <div class="text-center text-sm text-gray-500">
                    Нет аккаунта?
                    <Link :href="route('register')" :tabindex="5" class="text-blue-500 hover:underline">Зарегистрироваться</Link>
                </div>
            </form>
        </div>
    </div>
</template>
