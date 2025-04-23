<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Информация профиля</h2>
            <p class="mt-1 text-sm text-gray-600">
                Обновите информацию профиля вашей учетной записи и адрес электронной почты.
            </p>
        </header>

        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <div>
                <label for="name" class="block font-medium text-sm text-gray-700">Имя</label>
                <input
                    id="name"
                    type="text"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />
                <div v-if="form.errors.name" class="mt-2 text-sm text-red-600">
                    {{ form.errors.name }}
                </div>
            </div>

            <div>
                <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                <input
                    id="email"
                    type="email"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />
                <div v-if="form.errors.email" class="mt-2 text-sm text-red-600">
                    {{ form.errors.email }}
                </div>
            </div>

            <div>
                <label for="phone" class="block font-medium text-sm text-gray-700">Телефон (необязательно)</label>
                <input
                    id="phone"
                    type="tel"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    v-model="form.phone"
                    @input="applyPhoneMask"
                    placeholder="+7 (___) ___-__-__"
                    autocomplete="tel"
                />
                <div v-if="form.errors.phone" class="mt-2 text-sm text-red-600">
                    {{ form.errors.phone }}
                </div>
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800">
                    Ваш адрес электронной почты не подтвержден.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Нажмите здесь, чтобы повторно отправить письмо для подтверждения.
                    </Link>
                </p>
                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600"
                >
                    Новая ссылка для подтверждения была отправлена на ваш адрес электронной почты.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    :disabled="form.processing"
                >
                    Сохранить
                </button>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Сохранено.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>

<script setup lang="ts">
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

interface User {
    id: number;
    name: string;
    email: string;
    phone?: string | null;
    email_verified_at?: string | null; // Для проверки верификации
}

const props = defineProps<{
    user: User;
    mustVerifyEmail?: boolean; // Передается, если включена верификация email
    status?: string | null;
}>();

// Используем useForm для удобной работы с формами в Inertia
const form = useForm({
    name: props.user.name,
    email: props.user.email,
    phone: props.user.phone ?? '', // Инициализируем пустым значением, если null
});

// --- Маска для телефона ---
const applyPhoneMask = (event: Event) => {
    const input = event.target as HTMLInputElement;
    let value = input.value.replace(/\D/g, '');
    let formattedValue = '';
    // ... (логика маски) ...
    if (value.length > 0) {
        formattedValue = '+';
        if (value.length === 1 && value !== '7') {
            value = '7' + value;
        }
        formattedValue += value.substring(0, 1);
    }
    if (value.length > 1) {
        formattedValue += ' (' + value.substring(1, 4);
    }
    if (value.length > 4) {
        formattedValue += ') ' + value.substring(4, 7);
    }
    if (value.length > 7) {
        formattedValue += '-' + value.substring(7, 9);
    }
    if (value.length > 9) {
        formattedValue += '-' + value.substring(9, 11);
    }

    form.phone = formattedValue;
    input.value = formattedValue;
};


const submit = () => {
    form.patch(route('dashboard.profile'), { // Убедитесь, что маршрут назван 'dashboard.profile' и метод PATCH определен
        preserveScroll: true, // Сохраняет позицию скролла после обновления
        // onSuccess: () => { /* Действия при успехе */ },
        // onError: () => { /* Действия при ошибке */ },
    });
};

</script>
