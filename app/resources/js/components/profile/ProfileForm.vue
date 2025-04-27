<!-- resources/js/Components/Profile/ExtendedProfileForm.vue -->
<template>
    <form @submit.prevent="submit" class="space-y-6">
        <div>
            <label class="block font-medium text-sm text-gray-700">Полное имя</label>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-1">
                <div>
                    <input
                        type="text"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        v-model="form.last_name"
                        placeholder="Фамилия"
                    />
                </div>
                <div>
                    <input
                        type="text"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        v-model="form.first_name"
                        placeholder="Имя"
                        required
                    />
                </div>
                <div>
                    <input
                        type="text"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        v-model="form.middle_name"
                        placeholder="Отчество"
                    />
                </div>
            </div>
        </div>

        <div>
            <label class="block font-medium text-sm text-gray-700">Дата рождения</label>
            <input
                type="date"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                v-model="form.birthday"
            />
        </div>

        <div>
            <label class="block font-medium text-sm text-gray-700">Telegram ID</label>
            <input
                type="text"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                v-model="form.telegram_id"
                placeholder="@username"
            />
        </div>

        <div class="flex items-center gap-4">
            <button
                type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50"
                :disabled="form.processing"
            >
                Сохранить изменения
            </button>

        </div>
    </form>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    user: Object
});

const form = useForm({
    last_name: props.user.last_name,
    first_name: props.user.first_name,
    middle_name: props.user.middle_name,
    birthday: props.user.birthday,
    telegram_id: props.user.telegram_id
});

const submit = () => {
    form.patch(route('profile.update.additional'), {
        preserveScroll: true
    });
};
</script>
