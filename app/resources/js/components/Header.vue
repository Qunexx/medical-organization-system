<template>
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center">
                <Link :href="route('home')" class="text-2xl font-['Pacifico'] text-primary hover:text-primary/80 transition-colors">
                    МедИнформСистем
                </Link>
                <nav class="hidden md:flex ml-10 space-x-8 pointer-events-auto">
                    <Link  :href="route('home') + '#about'" class="text-gray-700 hover:text-primary font-medium ">
                        О нас
                    </Link>
                    <Link :href="route('home') + '#services'" class="text-gray-700 hover:text-primary font-medium ">
                        Услуги
                    </Link>
                    <Link :href="route('home') + '#doctors'" class="text-gray-700 hover:text-primary font-medium ">
                        Врачи
                    </Link>
                    <Link :href="route('home') + '#appointment'" class="text-gray-700 hover:text-primary font-medium ">
                        Запись на приём
                    </Link>
                    <Link :href="route('home') + '#reviews'" class="text-gray-700 hover:text-primary font-medium ">
                        Отзывы
                    </Link>
                    <Link :href="route('home') + '#contacts'" class="text-gray-700 hover:text-primary font-medium ">
                        Контакты
                    </Link>
                </nav>
            </div>

            <div class="flex items-center space-x-4">
                <template v-if="user">
                    <div class="hidden md:flex items-center space-x-4">
                        <template v-if="user.role === 'DOCTOR' || user.role === 'USER'">
                        <Link :href="route('patient.myConsultation')"
                              class="text-gray-700 hover:text-primary font-medium transition-colors">
                            Мои записи
                        </Link>
                        </template>

                        <template v-if="user.role === 'USER'">
                            <Link :href="route('patient.profile')"
                                  class="text-gray-700 hover:text-primary font-medium transition-colors">
                                Личный кабинет
                            </Link>
                        </template>

                        <template v-if="user.role === 'DOCTOR'">
                            <Link :href="route('patient.profile')"
                                  class="text-gray-700 hover:text-primary font-medium transition-colors">
                                Расписание
                            </Link>
                        </template>

                        <template v-if="user.role === 'ADMIN'">
                            <Link :href="route('platform.main')"
                                  class="text-gray-700 hover:text-primary font-medium transition-colors">
                                Администрирование
                            </Link>
                        </template>
                    </div>

                    <div class="flex items-center space-x-2">
                        <span class="text-gray-700 font-medium">{{ user.first_name }}</span>
                        <button @click="logout"
                                class="text-gray-700 hover:text-primary px-4 py-2 font-medium hover:underline transition-colors">
                            Выйти
                        </button>
                    </div>
                </template>

                <template v-else>
                    <div class="flex items-center space-x-2">
                        <Link :href="route('login')"
                              class="text-gray-700 hover:text-primary px-4 py-2 font-medium hover:underline whitespace-nowrap">
                            Войти
                        </Link>
                        <Link :href="route('register')"
                              class="bg-primary text-white px-4 py-2 rounded-button font-medium hover:bg-blue-600 transition-colors whitespace-nowrap">
                            Регистрация
                        </Link>
                    </div>
                </template>

                <button class="md:hidden w-10 h-10 flex items-center justify-center text-gray-700 hover:text-primary">
                    <i class="ri-menu-line ri-lg"></i>
                </button>
            </div>
        </div>
    </header>
</template>

<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const user = usePage().props.auth.user;

function logout() {
    router.post(route('logout'));
}
</script>

<style>
.font-\[\'Pacifico\'\] {
    font-family: 'Pacifico', cursive;
}

a:hover {
    text-decoration: underline;
    text-underline-offset: 4px;
}

button:hover {
    text-decoration: none;
}
 .container {
     max-width: 100%
 }
 @media (min-width: 1280px) {
     .container { max-width: 1280px }
 }

</style>
