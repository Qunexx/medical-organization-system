<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

interface Props {
    token: string;
    email: string;
}

const props = defineProps<Props>();

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const processing = ref(false);

const submit = () => {
    processing.value = true;
    form.post(route('password.store'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
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
            <Head title="Reset password" />

            <div class="text-center">
                <h2 class="mt-6 text-3xl font-bold tracking-tight text-gray-900">Сброс пароля</h2>
                <p class="mt-2 text-sm text-gray-600">Введите новый пароль для вашего аккаунта</p>
            </div>

            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="grid gap-6">
                    <div class="grid gap-2">
                        <label for="email" class="text-gray-700 text-sm font-bold block mb-2">Email</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            autocomplete="email"
                            v-model="form.email"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-100 leading-tight cursor-not-allowed"
                            readonly
                        />
                        <p v-if="form.errors.email" class="text-red-500 text-xs italic">{{ form.errors.email }}</p>
                    </div>

                    <div class="grid gap-2">
                        <label for="password" class="text-gray-700 text-sm font-bold block mb-2">Новый пароль</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            autocomplete="new-password"
                            v-model="form.password"
                            placeholder="Введите новый пароль"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            autofocus
                        />
                        <p v-if="form.errors.password" class="text-red-500 text-xs italic">{{ form.errors.password }}</p>
                    </div>

                    <div class="grid gap-2">
                        <label for="password_confirmation" class="text-gray-700 text-sm font-bold block mb-2">Подтвердите пароль</label>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            autocomplete="new-password"
                            v-model="form.password_confirmation"
                            placeholder="Повторите новый пароль"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        />
                        <p v-if="form.errors.password_confirmation" class="text-red-500 text-xs italic">{{ form.errors.password_confirmation }}</p>
                    </div>

                    <button
                        type="submit"
                        class="mt-4 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        :disabled="processing"
                    >
                        <span v-if="processing" class="inline-flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V1a1 1 0 110 2h-3a1 1 0 110 2h3a1 1 0 110 2H8a8 8 0 01-8 8z"></path>
                            </svg>
                            Обновление...
                        </span>
                        <span v-else>Обновить пароль</span>
                    </button>
                </div>

                <div class="text-center text-sm text-gray-500">
                    Вспомнили пароль?
                    <Link :href="route('login')" class="text-blue-500 hover:underline">Войти в аккаунт</Link>
                </div>
            </form>
        </div>
    </div>
</template>
