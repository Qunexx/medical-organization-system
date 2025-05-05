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
            <transition name="fade">
                <div v-if="showSuccessMessage" class="text-green-600 text-sm font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Данные успешно обновлены!
                </div>
            </transition>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import ToggleSwitch from '../../components/ToggleSwitch.vue';
import {ref} from "vue";

const props = defineProps({
    settings: Object
});
const showSuccessMessage = ref(false);

const form = useForm({
    access_email_notify: props.settings.access_email_notify,
    access_telegram_notify: props.settings.access_telegram_notify
});

const saveSettings = () => {
    form.post(route('patient.notification.update'), {
        preserveScroll: true,
        onSuccess: () => {
            showSuccessMessage.value = true;
            setTimeout(() => {
                showSuccessMessage.value = false;
            }, 3000);
        }
    });
};
</script>
