<template>
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center">
                <a href="#" class="text-2xl font-['Pacifico'] text-primary">МедИнформСистем</a>
                <nav class="hidden md:flex ml-10 space-x-8">
                    <a href="#about" class="text-gray-700 hover:text-primary font-medium">О нас</a>
                    <a href="#services" class="text-gray-700 hover:text-primary font-medium">Услуги</a>
                    <a href="#doctors" class="text-gray-700 hover:text-primary font-medium">Врачи</a>
                    <a href="#contacts" class="text-gray-700 hover:text-primary font-medium">Контакты</a>
                </nav>
            </div>
            <div class="flex items-center space-x-4">
                <a href="#" @click.prevent="openLoginModal" class="text-gray-700 hover:text-primary px-4 py-2 font-medium whitespace-nowrap">Войти</a>
                <a href="#" @click.prevent="openRegisterModal" class="bg-primary text-white px-4 py-2 !rounded-button font-medium hover:bg-blue-600 transition whitespace-nowrap">Регистрация</a>
                <button class="md:hidden w-10 h-10 flex items-center justify-center text-gray-700">
                    <i class="ri-menu-line ri-lg"></i> </button>
            </div>
        </div>
    </header>

    <Teleport to="body">
        <div v-if="isLoginModalOpen" @click.self="closeLoginModal" class="fixed inset-0 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4 relative">
                <button @click="closeLoginModal" class="absolute right-4 top-4 text-gray-500 hover:text-gray-700">
                    <i class="ri-close-line ri-lg"></i>
                </button>
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Вход в личный кабинет</h2>
                <form @submit.prevent="handleLogin" class="space-y-4">
                    <div>
                        <label for="loginEmail" class="block text-gray-700 mb-2">Email</label>
                        <input type="email" id="loginEmail" v-model="loginForm.email" class="w-full p-3 border border-gray-300 rounded text-gray-700" placeholder="example@mail.ru" required>
                    </div>
                    <div>
                        <label for="loginPassword" class="block text-gray-700 mb-2">Пароль</label>
                        <input type="password" id="loginPassword" v-model="loginForm.password" class="w-full p-3 border border-gray-300 rounded text-gray-700" placeholder="Введите пароль" required>
                    </div>
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" id="rememberMe" v-model="loginForm.rememberMe" class="custom-checkbox">
                            <span class="ml-2 text-gray-700">Запомнить меня</span>
                        </label>
                        <a href="#" class="text-primary hover:underline text-sm">Забыли пароль?</a>
                    </div>
                    <button type="submit" class="w-full bg-primary text-white py-3 !rounded-button font-medium hover:bg-blue-600 transition">Войти</button>
                </form>
                <div class="mt-6 text-center">
                    <p class="text-gray-600">Нет аккаунта? <a href="#" @click.prevent="switchToRegisterModal" class="text-primary hover:underline">Зарегистрироваться</a></p>
                </div>
            </div>
        </div>
    </Teleport>

    <Teleport to="body">
        <div v-if="isRegisterModalOpen" @click.self="closeRegisterModal" class="fixed inset-0 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4 relative">
                <button @click="closeRegisterModal" class="absolute right-4 top-4 text-gray-500 hover:text-gray-700">
                    <i class="ri-close-line ri-lg"></i>
                </button>
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Регистрация</h2>
                <form @submit.prevent="handleRegister" class="space-y-4">
                    <div>
                        <label for="registerName" class="block text-gray-700 mb-2">ФИО</label>
                        <input type="text" id="registerName" v-model="registerForm.name" class="w-full p-3 border border-gray-300 rounded text-gray-700" placeholder="Иванов Иван Иванович" required>
                    </div>
                    <div>
                        <label for="registerEmail" class="block text-gray-700 mb-2">Email</label>
                        <input type="email" id="registerEmail" v-model="registerForm.email" class="w-full p-3 border border-gray-300 rounded text-gray-700" placeholder="example@mail.ru" required>
                    </div>
                    <div>
                        <label for="registerPhone" class="block text-gray-700 mb-2">Телефон</label>
                        <input type="tel" id="registerPhone" :value="registerForm.phone" @input="applyPhoneMask" class="w-full p-3 border border-gray-300 rounded text-gray-700" placeholder="+7 (___) ___-__-__" required>
                    </div>
                    <div>
                        <label for="registerPassword" class="block text-gray-700 mb-2">Пароль</label>
                        <input type="password" id="registerPassword" v-model="registerForm.password" class="w-full p-3 border border-gray-300 rounded text-gray-700" placeholder="Введите пароль" required>
                    </div>
                    <div>
                        <label for="registerPasswordConfirm" class="block text-gray-700 mb-2">Подтверждение пароля</label>
                        <input type="password" id="registerPasswordConfirm" v-model="registerForm.passwordConfirm" class="w-full p-3 border border-gray-300 rounded text-gray-700" placeholder="Повторите пароль" required>
                    </div>
                    <p v-if="passwordMismatch" class="text-red-500 text-sm">Пароли не совпадают!</p>
                    <div class="flex items-start">
                        <input type="checkbox" id="registerConsent" v-model="registerForm.consent" class="custom-checkbox mr-2 mt-1" required>
                        <label for="registerConsent" class="text-gray-700 text-sm">Я согласен на обработку персональных данных и принимаю условия <a href="#" class="text-primary hover:underline">политики конфиденциальности</a></label>
                    </div>
                    <button type="submit" class="w-full bg-primary text-white py-3 !rounded-button font-medium hover:bg-blue-600 transition">Зарегистрироваться</button>
                </form>
                <div class="mt-6 text-center">
                    <p class="text-gray-600">Уже есть аккаунт? <a href="#" @click.prevent="switchToLoginModal" class="text-primary hover:underline">Войти</a></p>
                </div>
            </div>
        </div>
    </Teleport>

    <Teleport to="body">
        <div v-if="notification.show" :class="['fixed top-4 right-4 px-6 py-3 rounded shadow-lg text-white', notification.type === 'success' ? 'bg-green-500' : 'bg-red-500']">
            {{ notification.message }}
        </div>
    </Teleport>

</template>

<script setup lang="ts">
import { ref, reactive, watch } from 'vue';

// --- Состояние модальных окон ---
const isLoginModalOpen = ref(false);
const isRegisterModalOpen = ref(false);

// --- Функции открытия/закрытия модальных окон ---
const openLoginModal = () => {
    isRegisterModalOpen.value = false; // Закрыть другое окно, если открыто
    isLoginModalOpen.value = true;
    document.body.style.overflow = 'hidden'; // Блокировка прокрутки фона
};

const closeLoginModal = () => {
    isLoginModalOpen.value = false;
    document.body.style.overflow = ''; // Восстановление прокрутки
};

const openRegisterModal = () => {
    isLoginModalOpen.value = false; // Закрыть другое окно, если открыто
    isRegisterModalOpen.value = true;
    document.body.style.overflow = 'hidden';
};

const closeRegisterModal = () => {
    isRegisterModalOpen.value = false;
    document.body.style.overflow = '';
};

// --- Переключение между модальными окнами ---
const switchToRegisterModal = () => {
    closeLoginModal();
    // Небольшая задержка для плавности перехода (опционально)
    setTimeout(openRegisterModal, 150);
};

const switchToLoginModal = () => {
    closeRegisterModal();
    setTimeout(openLoginModal, 150);
};


// --- Форма входа ---
const loginForm = reactive({
    email: '',
    password: '',
    rememberMe: false,
});

const handleLogin = () => {
    console.log('Login attempt:', { ...loginForm });
    // Здесь будет вызов API для аутентификации
    // Показать уведомление об успехе/ошибке
    showNotification('Успешный вход!', 'success');
    closeLoginModal();
    // Очистка формы (опционально)
    loginForm.email = '';
    loginForm.password = '';
    loginForm.rememberMe = false;
};

// --- Форма регистрации ---
const registerForm = reactive({
    name: '',
    email: '',
    phone: '',
    password: '',
    passwordConfirm: '',
    consent: false,
});
const passwordMismatch = ref(false);

// Проверка совпадения паролей
watch(() => [registerForm.password, registerForm.passwordConfirm], ([newPass, newConfirm]) => {
    passwordMismatch.value = newPass !== '' && newConfirm !== '' && newPass !== newConfirm;
});

const handleRegister = () => {
    if (passwordMismatch.value) {
        showNotification('Пароли не совпадают!', 'error');
        return;
    }
    if (!registerForm.consent) {
        showNotification('Необходимо согласие на обработку данных!', 'error');
        return;
    }

    console.log('Register attempt:', {
        name: registerForm.name,
        email: registerForm.email,
        phone: registerForm.phone, // Отправить чистое значение или как требует API
        password: registerForm.password, // Не отправлять passwordConfirm
        consent: registerForm.consent
    });
    // Здесь будет вызов API для регистрации
    showNotification('Регистрация успешно завершена!', 'success');
    closeRegisterModal();
    // Очистка формы
    Object.assign(registerForm, {
        name: '', email: '', phone: '', password: '', passwordConfirm: '', consent: false
    });
};

// --- Маска для телефона ---
// Можно вынести в отдельный composable `usePhoneMask`
const applyPhoneMask = (event: Event) => {
    const input = event.target as HTMLInputElement;
    let value = input.value.replace(/\D/g, ''); // Удаляем все нецифровые символы
    let formattedValue = '';

    // Применяем маску +7 (XXX) XXX-XX-XX
    if (value.length > 0) {
        formattedValue = '+';
        if (value.length === 1 && value !== '7') {
            value = '7' + value; // Если первая цифра не 7, добавляем 7
        }
        formattedValue += value.substring(0, 1); // Добавляем 7 (или первую цифру)
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

    registerForm.phone = formattedValue; // Обновляем значение в реактивной форме
    // Важно обновить значение input напрямую, т.к. v-model может не успеть
    input.value = formattedValue;
};


// --- Система уведомлений ---
const notification = reactive({
    show: false,
    message: '',
    type: 'success' as 'success' | 'error', // Тип уведомления
});

let notificationTimeout: number | undefined;

const showNotification = (message: string, type: 'success' | 'error' = 'success', duration: number = 3000) => {
    notification.message = message;
    notification.type = type;
    notification.show = true;

    // Очищаем предыдущий таймаут, если есть
    if (notificationTimeout) {
        clearTimeout(notificationTimeout);
    }

    // Скрываем уведомление через 'duration' мс
    notificationTimeout = window.setTimeout(() => {
        notification.show = false;
    }, duration);
};


</script>

<style scoped>
/* Стили для Header.vue, если нужны специфичные стили, не покрытые Tailwind */
/* Стили для кастомных чекбоксов/свитчей лучше вынести в глобальный CSS или App.vue */
.font-\[\'Pacifico\'\] { /* Пример подключения кастомного шрифта, если он не глобально */
    font-family: 'Pacifico', cursive;
}

/* Стили для модальных окон можно добавить здесь или использовать глобальные */
</style>
