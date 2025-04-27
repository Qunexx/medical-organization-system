<!-- resources/js/Components/Profile/NotificationSettings.vue -->
<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-sm font-medium text-gray-900">Email-уведомления</h3>
                <p class="text-sm text-gray-500">Получать важные уведомления на почту</p>
            </div>
            <ToggleSwitch v-model="form.access_email_notify" />
        </div>

        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-sm font-medium text-gray-900">Telegram-уведомления</h3>
                <p class="text-sm text-gray-500">Мгновенные уведомления в мессенджере</p>
            </div>
            <ToggleSwitch v-model="form.access_telegram_notify" />
        </div>

        <div class="pt-4">
            <button
                type="submit"
                :disabled="form.processing"
                @click="saveSettings"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50"
            >
                Сохранить настройки
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import ToggleSwitch from '../../components/ToggleSwitch.vue';

const props = defineProps({
    settings: Object
});

const form = useForm({
    access_email_notify: props.settings.access_email_notify,
    access_telegram_notify: props.settings.access_telegram_notify
});

const saveSettings = () => {
    form.patch(route('notifications.settings.update'), {
        preserveScroll: true
    });
};
</script>
