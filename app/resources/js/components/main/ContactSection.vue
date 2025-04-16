<template>
    <section id="contacts" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Контакты</h2>
                <p class="text-gray-600 max-w-3xl mx-auto">Мы всегда готовы ответить на ваши вопросы</p>
            </div>
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Наши контакты</h3>
                        <div class="flex items-start mb-4">
                            <div class="w-10 h-10 flex items-center justify-center bg-blue-100 text-primary rounded-full mr-3 shrink-0">
                                <i class="ri-map-pin-line"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Адрес</h4>
                                <p class="text-gray-600">г.Йошкар-Ола</p>
                            </div>
                        </div>
                        <div class="flex items-start mb-4">
                            <div class="w-10 h-10 flex items-center justify-center bg-blue-100 text-primary rounded-full mr-3 shrink-0">
                                <i class="ri-phone-line"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Телефон</h4>
                                <p class="text-gray-600">+7 (495) 123-45-67</p>
                            </div>
                        </div>
                        <div class="flex items-start mb-4">
                            <div class="w-10 h-10 flex items-center justify-center bg-blue-100 text-primary rounded-full mr-3 shrink-0">
                                <i class="ri-mail-line"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Email</h4>
                                <p class="text-gray-600">info@medcenter.ru</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-10 h-10 flex items-center justify-center bg-blue-100 text-primary rounded-full mr-3 shrink-0">
                                <i class="ri-time-line"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Часы работы</h4>
                                <p class="text-gray-600">Пн-Пт: 8:00 - 20:00</p>
                                <p class="text-gray-600">Сб: 9:00 - 18:00</p>
                                <p class="text-gray-600">Вс: выходной</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Мы в социальных сетях</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 flex items-center justify-center bg-blue-100 text-primary rounded-full hover:bg-blue-200 transition">
                                <i class="ri-telegram-fill"></i>
                            </a>
                            <a href="#" class="w-10 h-10 flex items-center justify-center bg-blue-100 text-primary rounded-full hover:bg-blue-200 transition">
                                <i class="ri-vk-fill"></i>
                            </a>
                            <a href="#" class="w-10 h-10 flex items-center justify-center bg-blue-100 text-primary rounded-full hover:bg-blue-200 transition">
                                <i class="ri-instagram-line"></i>
                            </a>
                            <a href="#" class="w-10 h-10 flex items-center justify-center bg-blue-100 text-primary rounded-full hover:bg-blue-200 transition">
                                <i class="ri-whatsapp-line"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Напишите нам</h3>
                    <form @submit.prevent="handleContactSubmit">
                        <div class="mb-4">
                            <label for="contact-name" class="block text-gray-700 mb-2">ФИО</label>
                            <input type="text" id="contact-name" v-model="contactForm.name" class="w-full p-3 border border-gray-300 rounded text-gray-700" placeholder="Иванов Иван Иванович" required>
                        </div>
                        <div class="mb-4">
                            <label for="contact-email" class="block text-gray-700 mb-2">Email</label>
                            <input type="email" id="contact-email" v-model="contactForm.email" class="w-full p-3 border border-gray-300 rounded text-gray-700" placeholder="example@mail.ru" required>
                        </div>
                        <div class="mb-4">
                            <label for="contact-subject" class="block text-gray-700 mb-2">Тема</label>
                            <input type="text" id="contact-subject" v-model="contactForm.subject" class="w-full p-3 border border-gray-300 rounded text-gray-700" placeholder="Тема сообщения" required>
                        </div>
                        <div class="mb-6">
                            <label for="contact-message" class="block text-gray-700 mb-2">Сообщение</label>
                            <textarea id="contact-message" v-model="contactForm.message" class="w-full p-3 border border-gray-300 rounded text-gray-700 h-32" placeholder="Ваше сообщение" required></textarea>
                        </div>
                        <button type="submit" class="w-full bg-primary text-white py-3 !rounded-button font-medium hover:bg-blue-600 transition whitespace-nowrap">Отправить сообщение</button>
                    </form>
                </div>
            </div>
            <div class="mt-10 bg-white rounded-lg shadow-sm overflow-hidden h-96">
                <div class="h-full w-full bg-gray-200 flex items-center justify-center text-gray-500" style="background-image: url('#'); background-position: center; background-size: cover;">
                </div>
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
import { reactive } from 'vue';

const contactForm = reactive({
    name: '',
    email: '',
     phone: '',
    subject: '',
    message: '',
});


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

// --- Обработка отправки формы ---
const handleContactSubmit = () => {
    console.log('Contact form data:', { ...contactForm });
    // Здесь будет вызов API для отправки сообщения
    showNotification('Ваше сообщение успешно отправлено!', 'success');
    // Очистка формы
    Object.assign(contactForm, { name: '', email: '', subject: '', message: '' });
    // contactForm.phone = ''; // Если используется телефон
};
</script>

<style scoped>
/* Специфичные стили для ContactSection, если нужны */
</style>
