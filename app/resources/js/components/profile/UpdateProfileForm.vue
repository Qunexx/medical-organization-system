<template>
    <section class="profile-section">
        <header class="profile-header">
            <h2>Основная информация</h2>
            <p>Обновите основные данные профиля</p>
        </header>

        <form @submit.prevent="submit" class="profile-form">
            <!-- Составные части имени -->
            <div class="form-group">
                <label>Полное имя</label>
                <div class="name-fields">
                    <input
                        type="text"
                        v-model="form.last_name"
                        placeholder="Фамилия"
                    />
                    <input
                        type="text"
                        v-model="form.first_name"
                        placeholder="Имя"
                        required
                    />
                    <input
                        type="text"
                        v-model="form.middle_name"
                        placeholder="Отчество"
                    />
                </div>
            </div>

            <!-- Email -->
            <div class="form-group">
                <div class="flex justify-between items-center">
                    <label>Email</label>
                    <Link :href="route('patient.notification')" >Настроить уведомления →</Link>
                </div>
                <input
                    type="email"
                    v-model="form.email"
                    required
                />
                <div v-if="form.errors.email" class="error-message">
                    {{ form.errors.email }}
                </div>
            </div>

            <!-- Телефон -->
            <div class="form-group">
                <label>Телефон</label>
                <div class="phone-input">
                    <input
                        type="tel"
                        v-model="phoneDisplay"
                        @input="formatPhone"
                        placeholder="+7 (999) 999-99-99"
                        maxlength="18"
                    />
                </div>
                <div v-if="form.errors.phone" class="error-message">
                    {{ form.errors.phone }}
                </div>
            </div>

            <!-- Кнопка отправки -->
            <div class="form-actions">
                <button
                    type="submit"
                    :disabled="form.processing"
                >
                    <span v-if="!form.processing">Сохранить изменения</span>
                    <span v-else class="loading">
                        <span class="spinner"></span>
                        Сохранение...
                    </span>
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
        </form>
    </section>
</template>

<script setup>
import {Link, useForm} from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    user: Object
});

const form = useForm({
    last_name: props.user.last_name || '',
    first_name: props.user.first_name || '',
    middle_name: props.user.middle_name || '',
    email: props.user.email || '',
    phone: props.user.phone || ''
});

const phoneDisplay = ref(formatDisplayPhone(props.user.phone || ''));
const showSuccessMessage = ref(false);

function formatPhone(event) {
    const input = event.target;
    let numbers = input.value.replace(/\D/g, '').slice(1);
    numbers = numbers.slice(0, 10);

    // Форматирование отображаемого значения
    let formatted = '+7';
    if (numbers.length > 0) {
        formatted += ` (${numbers.slice(0,3)}`;
    }
    if (numbers.length > 3) {
        formatted += `) ${numbers.slice(3,6)}`;
    }
    if (numbers.length > 6) {
        formatted += `-${numbers.slice(6,8)}`;
    }
    if (numbers.length > 8) {
        formatted += `-${numbers.slice(8,10)}`;
    }

    phoneDisplay.value = formatted;
    form.phone = '+7' + numbers;
}

function formatDisplayPhone(value) {
    const numbers = value.replace(/\D/g, '').slice(1);
    if (!numbers) return '';
    return `+7 (${numbers.slice(0,3)}) ${numbers.slice(3,6)}-${numbers.slice(6,8)}-${numbers.slice(8,10)}`;
}

const submit = () => {
    form.post(route('patient.profile.main.update'), {
        preserveScroll: true,
        onSuccess: () => {
            showSuccessMessage.value = true;
            setTimeout(() => showSuccessMessage.value = false, 3000);
        }
    });
};
</script>

<style scoped>
.profile-section {
    background: #fff;
    padding: 24px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin: 20px 0;
}

.profile-header h2 {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    color: #333;
}

.profile-header p {
    color: #666;
    margin-bottom: 1.5rem;
}

.profile-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 1rem;
}

input:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
}

.name-fields {
    display: grid;
    gap: 1rem;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
}

button {
    background: #007bff;
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.2s;
}

button:hover {
    background: #0056b3;
}

button:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.loading {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.spinner {
    width: 1rem;
    height: 1rem;
    border: 2px solid rgba(255,255,255,0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.error-message {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

.success-message {
    color: #28a745;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
</style>
