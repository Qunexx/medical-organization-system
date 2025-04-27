<template>
    <div class="relative">
        <button
            @click="toggleNotifications"
            class="p-2 text-gray-600 hover:text-primary relative"
        >
            <i class="ri-notification-line ri-lg"></i>
            <span
                v-if="unreadCount"
                class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center"
            >
        {{ unreadCount }}
      </span>
        </button>

        <div
            v-show="showNotifications"
            class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-xl border z-50"
        >
            <div class="p-4">
                <h3 class="text-sm font-semibold mb-2">Уведомления</h3>
                <div
                    v-for="notification in notifications"
                    :key="notification.id"
                    class="p-2 hover:bg-gray-50 cursor-pointer text-sm"
                >
                    {{ notification.message }}
                </div>
                <div
                    v-if="!notifications.length"
                    class="text-gray-500 text-sm py-2"
                >
                    Нет новых уведомлений
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const showNotifications = ref(false);
const unreadCount = ref(2);
const notifications = ref([
    { id: 1, message: 'Новое сообщение в чате' },
    { id: 2, message: 'Запись на прием подтверждена' }
]);

const toggleNotifications = () => {
    showNotifications.value = !showNotifications.value;
};
</script>
