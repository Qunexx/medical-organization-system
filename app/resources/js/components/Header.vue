<template>
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-2xl font-['Pacifico'] text-primary">МедИнформСистем</a>
                <nav class="hidden md:flex ml-10 space-x-8">
                    <a href="#about" class="text-gray-700 hover:text-primary font-medium">О нас</a>
                    <a href="#services" class="text-gray-700 hover:text-primary font-medium">Услуги</a>
                    <a href="#doctors" class="text-gray-700 hover:text-primary font-medium">Врачи</a>
                </nav>
            </div>

            <div class="flex items-center space-x-4">
                <template v-if="user">
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="{{ route('consultations.index') }}" class="text-gray-700 hover:text-primary font-medium">Мои записи</a>

                        <template v-if="user.role === 'user'">
                            <a href="{{ route('profile.show') }}" class="text-gray-700 hover:text-primary font-medium">Личный кабинет</a>
                        </template>

                        <template v-if="user.role === 'doctor'">
                            <a href="{{ route('schedule.index') }}" class="text-gray-700 hover:text-primary font-medium">Расписание</a>
                        </template>

                        <template v-if="user.role === 'admin'">
                            <a href="{{ route('platform.main') }}" class="text-gray-700 hover:text-primary font-medium">Администрирование</a>
                        </template>
                    </div>

                    <div class="flex items-center space-x-2">
                        <span class="text-gray-700 font-medium">{{ user.name }}</span>
                        <button @click="logout"
                                class="text-gray-700 hover:text-primary px-4 py-2 font-medium link-info">
                            Выйти
                        </button>
                    </div>
                </template>

                <template v-else>
                    <div class="flex items-center space-x-2">
                        <a href="#" @click.prevent="goToLogin"
                           class="text-gray-700 hover:text-primary px-4 py-2 font-medium whitespace-nowrap">
                            Войти
                        </a>
                        <a href="#" @click.prevent="goToRegister"
                           class="bg-primary text-white px-4 py-2 !rounded-button font-medium hover:bg-blue-600 transition whitespace-nowrap">
                            Регистрация
                        </a>
                    </div>
                </template>

                <button class="md:hidden w-10 h-10 flex items-center justify-center text-gray-700">
                    <i class="ri-menu-line ri-lg"></i>
                </button>
            </div>
        </div>
    </header>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const user = usePage().props.auth.user;

function goToLogin() {
    router.visit(route('login'));
}

function goToRegister() {
    router.visit(route('register'));
}

function logout() {
    router.post(route('logout'));
}
</script>

<style scoped>
.font-\[\'Pacifico\'\] {
    font-family: 'Pacifico', cursive;
}
</style>
