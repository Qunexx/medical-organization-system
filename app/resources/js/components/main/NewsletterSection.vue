<template>
    <section class="py-16 bg-white bg-opacity-10">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Подпишитесь на наши новости</h2>
                <p class="text-gray-600 mb-8">Получайте актуальную информацию о новых услугах, акциях и полезные советы по здоровью</p>
                <form @submit.prevent="handleSubscription" class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto">
                    <input type="email" v-model="email" class="flex-grow p-3 border border-gray-300 rounded text-gray-700" placeholder="Ваш email" required>
                    <button type="submit" class="bg-primary text-white px-6 py-3 !rounded-button font-medium hover:bg-blue-600 transition whitespace-nowrap">Подписаться</button>
                </form>
            </div>
            <Teleport to="body">
                <div v-if="notification.show" :class="['fixed top-4 right-4 px-6 py-3 rounded shadow-lg text-white z-50', notification.type === 'success' ? 'bg-green-500' : 'bg-red-500']">
                    {{ notification.message }}
                </div>
            </Teleport>
        </div>
    </section>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue';

const email = ref('');

// --- Система уведомлений ---
const notification = reactive({
    show: false,
    message: '',
    type: 'success' as 'success' | 'error',
});
let notificationTimeout: number | undefined;
const showNotification = (message: string, type: 'success' | 'error' = 'success', duration: number = 3000) => {
    notification.message = message;
    notification.type = type;
    notification.show = true;
    if (notificationTimeout) clearTimeout(notificationTimeout);
    notificationTimeout = window.setTimeout(() => { notification.show = false; }, duration);
};

const handleSubscription = () => {
    console.log('Subscription email:', email.value);
    // Здесь будет вызов API для подписки
    showNotification('Вы успешно подписались на новости!', 'success');
    email.value = '';
};
</script>

<style scoped>
/* Специфичные стили для NewsletterSection, если нужны */
</style>
