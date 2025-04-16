<template>
    <section id="appointment" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Запись на прием</h2>
                <p class="text-gray-600 max-w-3xl mx-auto">Выберите специалиста, удобную дату и время для вашего визита</p>
            </div>
            <form @submit.prevent="handleAppointmentSubmit" class="bg-white rounded-lg shadow-md p-6 md:p-8 max-w-4xl mx-auto">
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Выберите специалиста и время</h3>
                        <div class="mb-4">
                            <label for="specialty" class="block text-gray-700 mb-2">Специальность</label>
                            <div class="relative">
                                <select id="specialty" v-model="appointmentForm.specialty" class="w-full p-3 border border-gray-300 rounded text-gray-700 bg-white appearance-none pr-8">
                                    <option value="">Выберите специальность</option>
                                    <option value="cardiology">Кардиология</option>
                                    <option value="neurology">Неврология</option>
                                    <option value="gastroenterology">Гастроэнтерология</option>
                                    <option value="endocrinology">Эндокринология</option>
                                    <option value="ophthalmology">Офтальмология</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <i class="ri-arrow-down-s-line text-gray-500"></i>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="doctor" class="block text-gray-700 mb-2">Врач</label>
                            <div class="relative">
                                <select id="doctor" v-model="appointmentForm.doctor" class="w-full p-3 border border-gray-300 rounded text-gray-700 bg-white appearance-none pr-8">
                                    <option value="">Выберите врача</option>
                                    <option value="ivanov">Иванов Сергей Петрович</option>
                                    <option value="petrova">Петрова Анна Михайловна</option>
                                    <option value="smirnov">Смирнов Алексей Владимирович</option>
                                    <option value="kozlova">Козлова Елена Дмитриевна</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <i class="ri-arrow-down-s-line text-gray-500"></i>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Дата</label>
                            <input type="date" v-model="appointmentForm.date" class="w-full p-3 border border-gray-300 rounded text-gray-700">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Доступное время</label>
                            <div class="grid grid-cols-3 gap-2">
                                <button
                                    v-for="timeSlot in availableTimes"
                                    :key="timeSlot"
                                    type="button"
                                    @click="selectTime(timeSlot)"
                                    :class="[
                    'p-2 border rounded !rounded-button whitespace-nowrap',
                    appointmentForm.time === timeSlot
                      ? 'bg-blue-50 border-primary text-primary'
                      : 'border-gray-300 text-gray-700 hover:bg-blue-50 hover:border-primary'
                  ]"
                                >
                                    {{ timeSlot }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Ваши данные</h3>
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 mb-2">ФИО</label>
                            <input type="text" id="name" v-model="appointmentForm.name" class="w-full p-3 border border-gray-300 rounded text-gray-700" placeholder="Иванов Иван Иванович" required>
                        </div>
                        <div class="mb-4">
                            <label for="phone" class="block text-gray-700 mb-2">Телефон</label>
                            <input type="tel" id="phone" :value="appointmentForm.phone" @input="applyPhoneMask" class="w-full p-3 border border-gray-300 rounded text-gray-700" placeholder="+7 (___) ___-__-__" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 mb-2">Email</label>
                            <input type="email" id="email" v-model="appointmentForm.email" class="w-full p-3 border border-gray-300 rounded text-gray-700" placeholder="example@mail.ru" required>
                        </div>
                        <div class="mb-6">
                            <label for="comment" class="block text-gray-700 mb-2">Комментарий (необязательно)</label>
                            <textarea id="comment" v-model="appointmentForm.comment" class="w-full p-3 border border-gray-300 rounded text-gray-700 h-24" placeholder="Опишите ваши симптомы или причину обращения"></textarea>
                        </div>
                        <div class="mb-6 flex items-start">
                            <input type="checkbox" id="consent" v-model="appointmentForm.consent" class="custom-checkbox mr-2 mt-1" required>
                            <label for="consent" class="text-gray-700 text-sm">Я согласен на обработку персональных данных и принимаю условия <a href="#" class="text-primary hover:underline">политики конфиденциальности</a></label>
                        </div>
                        <button type="submit" class="w-full bg-primary text-white py-3 !rounded-button font-medium hover:bg-blue-600 transition whitespace-nowrap">Записаться на прием</button>
                    </div>
                </div>
            </form>
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

const appointmentForm = reactive({
    specialty: '',
    doctor: '',
    date: '',
    time: '',
    name: '',
    phone: '',
    email: '',
    comment: '',
    consent: false,
});

const availableTimes = ref(['09:00', '09:30', '10:00', '10:30', '11:00', '11:30']);

const selectTime = (time: string) => {
    appointmentForm.time = time;
};

const applyPhoneMask = (event: Event) => {
    const input = event.target as HTMLInputElement;
    let value = input.value.replace(/\D/g, '');
    let formattedValue = '';

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

    appointmentForm.phone = formattedValue;
    input.value = formattedValue;
};


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

const handleAppointmentSubmit = () => {
    if (!appointmentForm.consent) {
        showNotification('Необходимо согласие на обработку данных!', 'error');
        return;
    }
    if (!appointmentForm.time) {
        showNotification('Пожалуйста, выберите время приема!', 'error');
        return;
    }
    console.log('Appointment data:', { ...appointmentForm });
    showNotification('Вы успешно записаны на прием!', 'success');
    Object.assign(appointmentForm, {
        specialty: '', doctor: '', date: '', time: '', name: '',
        phone: '', email: '', comment: '', consent: false
    });
};
</script>

<style scoped>

.custom-checkbox {
    appearance: none;
    width: 1.25rem;
    height: 1.25rem;
    border: 2px solid #3b82f6;
    border-radius: 4px;
    position: relative;
    cursor: pointer;
    vertical-align: middle;
    display: inline-block;
    flex-shrink: 0;
}
.custom-checkbox:checked {
    background-color: #3b82f6;
}
.custom-checkbox:checked::after {
    content: '';
    position: absolute;
    left: 5px;
    top: 1px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}
</style>
