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
                            <div>
                                <h4 class="font-semibold text-gray-800">Адрес</h4>
                                <p class="text-gray-600">г.Йошкар-Ола</p>
                            </div>
                        </div>
                        <div class="flex items-start mb-4">
                            <div>
                                <h4 class="font-semibold text-gray-800">Телефон</h4>
                                <p class="text-gray-600">+7 (123) 456-78-90</p>
                            </div>
                        </div>
                        <div class="flex items-start mb-4">
                            <div>
                                <h4 class="font-semibold text-gray-800">Email</h4>
                                <p class="text-gray-600">info@medinformsystem.qunexx.ru</p>
                            </div>
                        </div>
                        <div class="flex items-start">
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
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Напишите нам</h3>
                    <form @submit.prevent="submitFeedback">
                        <div class="mb-4">
                            <label for="contact-name" class="block text-gray-700 mb-2">ФИО</label>
                            <input type="text" id="contact-name" v-model="contactForm.fio" class="w-full p-3 border border-gray-300 rounded text-gray-700" placeholder="Иванов Иван Иванович" required>
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
                    <div v-if="showSuccessMessage" class="text-green-600 text-sm font-medium flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    Сообщение успешно отправлено
                    </div>
                </div>
            </div>
            <div class="mt-10 bg-white rounded-lg shadow-sm overflow-hidden h-96">
                <div class="h-full w-full bg-gray-200 flex items-center justify-center text-gray-500" style="background-image: url('storage/map.png'); background-position: center; background-size: cover;">
                </div>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import {reactive, ref} from 'vue';
import {useForm} from "@inertiajs/vue3";

const contactForm = useForm({
    fio: '',
    email: '',
    subject: '',
    message: '',
});
const showSuccessMessage = ref(false);
const submitFeedback = () => {
    contactForm.post(route('feedback.submit'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            contactForm.reset();
            showSuccessMessage.value = true;
            setTimeout(() => {
                showSuccessMessage.value = false;
            }, 3000);
        },
        onError: (errors) => {
            console.error('Ошибки при отправке:', errors);
        }
    });
};
</script>

<style scoped>
</style>
