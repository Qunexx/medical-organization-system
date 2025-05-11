<script setup lang="ts">
import {Head, useForm, Link, router} from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps<{
    canResetPassword: boolean;
}>();

const form = useForm({
    name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
});

const processing = ref(false);

const submit = () => {
    processing.value = true;
    form.post(route('register'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
            processing.value = false;
        },
        onError: () => {
            processing.value = false;
        },
    });
};

const formatPhoneNumber = (event) => {
    let phone = event.target.value.replace(/\D/g, '');
    let formatted = '';

    if (phone.length > 0) {
        formatted = '+7 ';
        if (phone.length > 1) {
            phone = phone.substring(1);
        }
    }

    if (phone.length > 0) {
        formatted += '(' + phone.substring(0, 3);
    }
    if (phone.length >= 4) {
        formatted += ') ' + phone.substring(3, 6);
    }
    if (phone.length >= 7) {
        formatted += '-' + phone.substring(6, 8);
    }
    if (phone.length >= 9) {
        formatted += '-' + phone.substring(8, 10);
    }

    if (phone.length > 10) {
        phone = phone.substring(0, 10);
    }

    this.form.phone = formatted;
    event.target.value = formatted;
}

const handleGoToHome = () => {
    router.visit(route('home'));
};
</script>

<template>
    <div class="grid h-screen place-items-center bg-gray-100">
        <div class="w-full max-w-md p-6 space-y-8 bg-white rounded-lg shadow-md">
            <Head title="Register" />

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
                <h2 class="mt-6 text-3xl font-bold tracking-tight text-gray-900">Создайте новый аккаунт</h2>
                <p class="mt-2 text-sm text-gray-600">Введите свои данные для регистрации</p>
            </div>

            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="grid gap-6">
                    <div class="grid gap-2">
                        <label for="name" class="text-gray-700 text-sm font-bold block mb-2">Имя</label>
                        <input
                            id="name"
                            type="text"
                            required
                            autofocus
                            tabindex="1"
                            autocomplete="name"
                            v-model="form.name"
                            placeholder="Полное имя"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        />
                        <p v-if="form.errors.name" class="text-red-500 text-xs italic">{{ form.errors.name }}</p>
                    </div>

                    <div class="grid gap-2">
                        <label for="phone" class="text-gray-700 text-sm font-bold block mb-2">Номер телефона</label>
                        <input
                            id="phone"
                            type="tel"
                            required
                            tabindex="1"
                            autocomplete="tel"
                            v-model="form.phone"
                            @input="formatPhoneNumber"
                            placeholder="+7 (999) 999-99-99"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            :class="{ 'border-red-500': form.errors.phone }"
                        />
                        <p v-if="form.errors.phone" class="text-red-500 text-xs italic">{{ form.errors.phone }}</p>
                    </div>

                    <div class="grid gap-2">
                        <label for="email" class="text-gray-700 text-sm font-bold block mb-2">Email</label>
                        <input
                            id="email"
                            type="email"
                            required
                            tabindex="2"
                            autocomplete="email"
                            v-model="form.email"
                            placeholder="email@example.com"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        />
                        <p v-if="form.errors.email" class="text-red-500 text-xs italic">{{ form.errors.email }}</p>
                    </div>

                    <div class="grid gap-2">
                        <label for="password" class="text-gray-700 text-sm font-bold block mb-2">Пароль</label>
                        <input
                            id="password"
                            type="password"
                            required
                            tabindex="3"
                            autocomplete="new-password"
                            v-model="form.password"
                            placeholder="Пароль"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        />
                        <p v-if="form.errors.password" class="text-red-500 text-xs italic">{{ form.errors.password }}</p>
                    </div>

                    <div class="grid gap-2">
                        <label for="password_confirmation" class="text-gray-700 text-sm font-bold block mb-2">Подтвердите пароль</label>
                        <input
                            id="password_confirmation"
                            type="password"
                            required
                            tabindex="4"
                            autocomplete="new-password"
                            v-model="form.password_confirmation"
                            placeholder="Подтвердите пароль"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        />
                        <p v-if="form.errors.password_confirmation" class="text-red-500 text-xs italic">{{ form.errors.password_confirmation }}</p>
                    </div>

                    <button
                        type="submit"
                        class="mt-4 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        tabindex="5"
                        :disabled="processing"
                    >
                        <span v-if="processing" class="inline-flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V1a1 1 0 110 2h-3a1 1 0 110 2h3a1 1 0 110 2H8a8 8 0 01-8 8z"></path>
                            </svg>
                            Регистрация...
                        </span>
                        <span v-else>Зарегистрироваться</span>
                    </button>
                </div>

                <div class="text-center text-sm text-gray-500">
                    Уже есть аккаунт?
                    <Link :href="route('login')" :tabindex="6" class="text-blue-500 hover:underline">Войти</Link>
                </div>
            </form>
        </div>
    </div>
</template>
