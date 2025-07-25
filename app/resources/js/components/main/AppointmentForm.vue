<template>
    <section id="appointment" class="py-16 bg-gray-50">

        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Запись на прием</h2>
                <p class="text-gray-600 max-w-3xl mx-auto">Выберите специалиста, удобную дату и время для вашего визита</p>
            </div>
            <div v-if="!isAuthenticated" class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <Link  :href="route('register')">
                        <p class="text-sm text-yellow-700">
                            Для записи на прием необходимо войти или зарегистрироваться
                        </p>
                        </Link>
                    </div>

                </div>
            </div>

            <form
                @submit.prevent="handleAppointmentSubmit"
                :class="[
        'bg-white rounded-lg shadow-md p-6 md:p-8 max-w-4xl mx-auto',
        !isAuthenticated && 'opacity-75'
    ]"
            >
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Выберите специалиста и время</h3>

                        <div class="mb-4">
                            <label for="specialty" class="block text-gray-700 mb-2">Специальность</label>
                            <div class="relative">
                                <div
                                    v-if="!isAuthenticated"
                                    class="absolute inset-0 bg-white/80 z-10 flex items-center justify-center"
                                >
                                    <p class="text-lg font-medium text-gray-600">
                                        Авторизуйтесь для записи
                                    </p>
                                </div>
                                <select
                                    id="specialty"
                                    v-model="appointmentForm.specialty"
                                    class="w-full p-3 border border-gray-300 rounded text-gray-700 bg-white appearance-none pr-8"
                                >
                                    <option value="">Выберите специальность</option>
                                    <option
                                        v-for="specialty in uniqueSpecialties"
                                        :key="specialty"
                                        :value="specialty"
                                    >
                                        {{ specialty }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="doctor" class="block text-gray-700 mb-2">Врач</label>
                            <div class="relative">
                                <select
                                    id="doctor"
                                    v-model="appointmentForm.doctor"
                                    :disabled="!isAuthenticated"
                                    class="w-full p-3 border border-gray-300 rounded text-gray-700 bg-white appearance-none pr-8"
                                >
                                    <option value="">Выберите врача</option>
                                    <option
                                        v-for="doctor in filteredDoctors"
                                        :key="doctor.id"
                                        :value="doctor.id"
                                    >
                                        {{ doctor.user.last_name }}
                                        {{ doctor.user.first_name }}
                                        ({{ doctorSpecializations(doctor) }})
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Желаемая дата</label>
                            <input
                                type="date"
                                v-model="appointmentForm.date"
                                class="w-full p-3 border border-gray-300 rounded text-gray-700"
                                required
                                :disabled="!isAuthenticated"
                            >
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Желаемое время</label>
                            <div class="grid grid-cols-4 gap-2">
                                <button
                                    v-for="time in timeSlots"
                                    :key="time"
                                    type="button"
                                    @click="selectTime(time)"
                                    :class="[
                'py-2 text-sm rounded border transition-colors',
                appointmentForm.time === time
                    ? 'bg-primary text-white border-primary'
                    : 'bg-white border-gray-300 hover:border-primary',
                isTimeDisabled(time) ? 'opacity-50 cursor-not-allowed' : ''
            ]"
                                    :disabled="isTimeDisabled(time)"
                                >
                                    {{ time }}
                                </button>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">Доступное время с 09:00 до 18:00</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Ваши данные</h3>

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 mb-2">ФИО</label>
                            <input
                                type="text"
                                id="name"
                                v-model="appointmentForm.name"
                                :disabled="!isAuthenticated"
                                :class="[
                  'w-full p-3 border rounded text-gray-700',
                  !isAuthenticated ? 'bg-gray-100 cursor-not-allowed' : ''
                ]"
                                placeholder="Иванов Иван Иванович"
                                required
                            >
                            <p v-if="!isAuthenticated" class="text-sm text-gray-500 mt-1">
                                Авторизуйтесь для автоматического заполнения
                            </p>
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="block text-gray-700 mb-2">Телефон</label>
                            <input
                                type="tel"
                                id="phone"
                                :value="appointmentForm.phone"
                                @input="applyPhoneMask"
                                :disabled="!isAuthenticated"
                                :class="[
                  'w-full p-3 border rounded text-gray-700',
                  !isAuthenticated ? 'bg-gray-100 cursor-not-allowed' : ''
                ]"
                                placeholder="+7 (___) ___-__-__"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 mb-2">Email</label>
                            <input
                                type="email"
                                id="email"
                                v-model="appointmentForm.email"
                                :disabled="!isAuthenticated"
                                :class="[
                  'w-full p-3 border rounded text-gray-700',
                  !isAuthenticated ? 'bg-gray-100 cursor-not-allowed' : ''
                ]"
                                placeholder="example@mail.ru"
                                required
                            >
                        </div>

                        <div class="mb-6">
                            <label for="comment" class="block text-gray-700 mb-2">Комментарий (необязательно)</label>
                            <textarea
                                id="comment"
                                v-model="appointmentForm.comment"
                                class="w-full p-3 border border-gray-300 rounded text-gray-700 h-24"
                                placeholder="Опишите ваши симптомы или причину обращения"
                            ></textarea>
                        </div>

                        <div class="mb-6 flex items-start">
                            <input
                                type="checkbox"
                                id="consent"
                                v-model="appointmentForm.consent"
                                class="custom-checkbox mr-2 mt-1"
                                :disabled="!isAuthenticated"
                                required
                            >
                            <label for="consent" class="text-gray-700 text-sm">
                                Я согласен на обработку персональных данных и принимаю условия
                                <a href="#" class="text-primary hover:underline">политики конфиденциальности</a>
                            </label>
                        </div>

                        <button
                            type="submit"
                            :class="[
                'w-full py-3 rounded font-medium transition whitespace-nowrap',
                isAuthenticated
                  ? 'bg-primary text-white hover:bg-blue-600'
                  : 'bg-gray-400 text-gray-700 cursor-not-allowed'
              ]"
                        >
                            {{ isAuthenticated ? 'Записаться на прием' : 'Войдите для записи' }}
                        </button>
                    </div>
                </div>
            </form>

            <Teleport to="body">
                <div
                    v-if="notification.show"
                    :class="[
            'fixed top-4 right-4 px-6 py-3 rounded shadow-lg text-white z-50 transition-opacity',
            notification.type === 'success' ? 'bg-green-500' : 'bg-red-500'
          ]"
                >
                    {{ notification.message }}
                </div>
            </Teleport>
        </div>
    </section>
</template>

<script setup lang="ts">
import { ref, reactive, onMounted, computed, watch } from 'vue';
import {usePage, router, Link} from '@inertiajs/vue3';


const page = usePage();
const isAuthenticated = ref(false);
const doctors = ref<Array<any>>([]);
const selectedDoctorFromURL = ref('');
const specializations = ref('');
interface AppointmentForm {
    specialty: string;
    doctor: string;
    date: string;
    time: string;
    name: string;
    phone: string;
    email: string;
    comment: string;
    consent: boolean;
}

const appointmentForm = reactive<AppointmentForm>({
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

onMounted(() => {
    doctors.value = page.props.doctors;

    const urlParams = new URLSearchParams(window.location.search);
    const doctorId = urlParams.get('doctor');

    if (doctorId) {
        selectedDoctorFromURL.value = doctorId;
        handleURLPreselection();
    }

    if (page.props.auth.user) {
        isAuthenticated.value = true;
        const user = page.props.auth.user;
        appointmentForm.name = [user.last_name, user.first_name, user.middle_name]
            .filter(Boolean).join(' ');
        appointmentForm.phone = user.phone || '';
        appointmentForm.email = user.email || '';
    }
});

const handleURLPreselection = () => {
    const doctor = doctors.value.find(d => d.id == selectedDoctorFromURL.value);
    if (doctor) {
        appointmentForm.doctor = doctor.id;
        if (doctor.specializations.length > 0) {
            appointmentForm.specialty = doctor.specializations[0].name;
        }
        scrollToAppointment();
        doctors.value = [...doctors.value];
    }
};

const scrollToAppointment = () => {
    setTimeout(() => {
        const element = document.getElementById('appointment');
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
        }
    }, 100);
};

const uniqueSpecialties = computed(() => {
    const specialties = new Set<string>();

    if (appointmentForm.doctor) {
        const doctor = doctors.value.find(d => d.id === appointmentForm.doctor);
        doctor?.specializations.forEach((spec: any) => {
            specialties.add(spec.name);
        });
    } else {
        doctors.value.forEach(doctor => {
            doctor.specializations.forEach((spec: any) => {
                specialties.add(spec.name);
            });
        });
    }

    return Array.from(specialties).sort();
});

const filteredDoctors = computed(() => {
    if (!appointmentForm.specialty) return doctors.value;
    return doctors.value.filter(doctor =>
        doctor.specializations.some((spec: any) =>
            spec.name === appointmentForm.specialty
        )
    );
});

const doctorSpecializations = (doctor: any) => {
    return doctor.specializations.map((spec: any) => spec.name).join(', ');
};

watch(() => appointmentForm.doctor, (newVal, oldVal) => {
    if (newVal) {
        const doctor = doctors.value.find(d => d.id === newVal);
        if (doctor?.specializations?.length) {
            appointmentForm.specialty = doctor.specializations[0].name;
        }
    } else {
        appointmentForm.specialty = '';
    }
});

watch(() => appointmentForm.specialty, (newVal, oldVal) => {
    if (newVal && !oldVal) {
        appointmentForm.doctor = '';
    }
});
const selectTime = (time: string) => {
    if (isAuthenticated.value) {
        appointmentForm.time = time;
    }
};

const applyPhoneMask = (event: Event) => {
    if (!isAuthenticated.value) return;

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

interface Notification {
    show: boolean;
    message: string;
    type: 'success' | 'error';
}

const notification = reactive<Notification>({
    show: false,
    message: '',
    type: 'success',
});

let notificationTimeout: number | undefined;

const showNotification = (
    message: string,
    type: 'success' | 'error' = 'success',
    duration: number = 3000
) => {
    notification.message = message;
    notification.type = type;
    notification.show = true;

    if (notificationTimeout) clearTimeout(notificationTimeout);
    notificationTimeout = window.setTimeout(() => {
        notification.show = false;
    }, duration);
};

const handleAppointmentSubmit = () => {
    if (!isAuthenticated.value) {
        showNotification('Для записи необходимо войти в систему!', 'error');
        return;
    }

    if (!appointmentForm.consent) {
        showNotification('Необходимо согласие на обработку данных!', 'error');
        return;
    }

    if (!appointmentForm.time) {
        showNotification('Пожалуйста, выберите время приема!', 'error');
        return;
    }

        router.post(route('patient.appointment.make'), {
            doctor_id: appointmentForm.doctor,
            date: appointmentForm.date,
            specialty: appointmentForm.specialty,
            time: appointmentForm.time,
            name: appointmentForm.name,
            phone: appointmentForm.phone.replace(/\D/g, ''),
            email: appointmentForm.email,
            comment: appointmentForm.comment,
        }, {
            onSuccess: () => {
                showNotification('Вы успешно записаны на прием!', 'success');
                Object.assign(appointmentForm, {
                    specialty: '',
                    doctor: '',
                    date: '',
                    time: '',
                    comment: '',
                    consent: false,
                });
            },
            onError: (errors) => {
                const message = Object.values(errors).join('\n') || 'Ошибка при записи!';
                showNotification(message, 'error');
            }
        });
};

const timeSlots = ref<string[]>([]);
for (let hour = 9; hour <= 18; hour++) {
    for (let minute = 0; minute < 60; minute += 30) {
        if (hour === 18 && minute > 0) break;
        timeSlots.value.push(
            `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`
        );
    }
}

const isTimeDisabled = (time: string) => {
    if (!appointmentForm.date) return true;

    const selectedDate = new Date(appointmentForm.date);
    const now = new Date();
    if (selectedDate.toDateString() === now.toDateString()) {
        const [hours, minutes] = time.split(':').map(Number);
        const selectedTime = new Date();
        selectedTime.setHours(hours, minutes, 0, 0);

        return selectedTime < now;
    }

    return false;
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

.custom-checkbox:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
