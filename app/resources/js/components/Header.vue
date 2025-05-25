<template>
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center">
                <Link :href="route('home')" class="text-2xl font-['Pacifico'] text-primary hover:text-primary/80 transition-colors">
                    МедИнформСистем
                </Link>
                <nav class="hidden md:flex ml-10 space-x-8">
                    <button
                        v-for="(link, index) in mainLinks"
                        :key="index"
                        @click="smoothScroll(link.anchor)"
                        class="text-gray-700 hover:text-primary font-medium"
                    >
                        {{ link.title }}
                    </button>
                </nav>
            </div>

            <div class="flex items-center space-x-4">
                <template v-if="user">
                    <div class="hidden md:flex items-center space-x-4">
                        <template v-if="user.role === 'USER'">
                            <Link :href="route('patient.myConsultation')"
                                  class="text-gray-700 hover:text-primary font-medium transition-colors">
                                Мои записи
                            </Link>
                            <Link :href="route('patient.profile')"
                                  class="text-gray-700 hover:text-primary font-medium transition-colors">
                                Личный кабинет
                            </Link>
                        </template>

                        <template v-if="user.role === 'DOCTOR'">
                            <Link :href="route('platform.appointment')"
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

                    <div class="hidden md:flex items-center space-x-2">
                        <span class="text-gray-700 font-medium">{{ user.first_name }}</span>
                        <button @click="logout"
                                class="text-gray-700 hover:text-primary px-4 py-2 font-medium hover:underline transition-colors">
                            Выйти
                        </button>
                    </div>
                </template>

                <template v-else>
                    <div class="hidden md:flex items-center space-x-2">
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

                <button
                    @click="toggleMobileMenu"
                    class="md:hidden w-10 h-10 flex items-center justify-center text-gray-700 hover:text-primary"
                    :aria-expanded="isMobileMenuOpen"
                >
                    <i
                        class="ri-lg transition-transform duration-200"
                        :class="isMobileMenuOpen ? 'ri-close-line' : 'ri-menu-line'"
                    ></i>
                </button>
            </div>
        </div>

        <Transition
            enter-active-class="transition-all duration-300 ease-out"
            leave-active-class="transition-all duration-200 ease-in"
            enter-from-class="opacity-0 -translate-y-4"
            leave-to-class="opacity-0 -translate-y-4"
        >
            <div
                v-show="isMobileMenuOpen"
                class="md:hidden bg-white shadow-lg"
            >
                <nav class="px-4 py-2 space-y-2">
                    <button
                        v-for="(link, index) in mainLinks"
                        :key="index"
                        @click="smoothScroll(link.anchor)"
                        class="block w-full text-left px-4 py-2 text-gray-700 hover:text-primary hover:bg-gray-50 rounded-md transition-colors font-medium"
                    >
                        {{ link.title ?? 'Главная' }}
                    </button>

                    <template v-if="user">
                        <div class="border-t pt-2 mt-2">
                            <template v-if="user.role === 'USER'">
                                <Link @click="closeMobileMenu" :href="route('patient.myConsultation')"
                                      class="block px-4 py-2 text-gray-700 hover:text-primary hover:bg-gray-50 rounded-md transition-colors font-medium">
                                    Мои записи
                                </Link>
                                <Link @click="closeMobileMenu" :href="route('patient.profile')"
                                      class="block px-4 py-2 text-gray-700 hover:text-primary hover:bg-gray-50 rounded-md transition-colors font-medium">
                                    Личный кабинет
                                </Link>
                            </template>

                            <template v-if="user.role === 'DOCTOR'">
                                <Link @click="closeMobileMenu" :href="route('platform.appointment')"
                                      class="block px-4 py-2 text-gray-700 hover:text-primary hover:bg-gray-50 rounded-md transition-colors font-medium">
                                    Расписание
                                </Link>
                            </template>

                            <template v-if="user.role === 'ADMIN'">
                                <Link @click="closeMobileMenu" :href="route('platform.main')"
                                      class="block px-4 py-2 text-gray-700 hover:text-primary hover:bg-gray-50 rounded-md transition-colors font-medium">
                                    Администрирование
                                </Link>
                            </template>

                            <button @click="logout"
                                    class="block w-full text-left px-4 py-2 text-gray-700 hover:text-primary hover:bg-gray-50 rounded-md transition-colors font-medium">
                                Выйти
                            </button>
                        </div>
                    </template>

                    <template v-else>
                        <div class="border-t pt-2 mt-2">
                            <Link @click="closeMobileMenu" :href="route('login')"
                                  class="block px-4 py-2 text-gray-700 hover:text-primary hover:bg-gray-50 rounded-md transition-colors font-medium">
                                Войти
                            </Link>
                            <Link @click="closeMobileMenu" :href="route('register')"
                                  class="block px-4 py-2 bg-primary text-white hover:bg-blue-600 rounded-md transition-colors font-medium">
                                Регистрация
                            </Link>
                        </div>
                    </template>
                </nav>
            </div>
        </Transition>
    </header>
</template>

<script setup lang="ts">
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const user = usePage().props.auth.user;
const isMobileMenuOpen = ref(false);

const mainLinks = [
    { title: 'О нас', anchor: 'about' },
    { title: 'Услуги', anchor: 'services' },
    { title: 'Врачи', anchor: 'doctors' },
    { title: 'Запись на приём', anchor: 'appointment' },
    { title: 'Отзывы', anchor: 'reviews' },
    { title: 'Контакты', anchor: 'contacts' }
];

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const closeMobileMenu = () => {
    isMobileMenuOpen.value = false;
};

const smoothScroll = (anchor: string) => {
    closeMobileMenu();
    const element = document.getElementById(anchor);

    if (element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
        window.history.replaceState({}, '', `${route('home')}#${anchor}`);
    }
};

const handleClickOutside = (event: MouseEvent) => {
    const header = document.querySelector('header');
    const button = document.querySelector('[aria-expanded]');

    if (!header?.contains(event.target as Node) && !button?.contains(event.target as Node)) {
        closeMobileMenu();
    }
};

const handleEscapeKey = (event: KeyboardEvent) => {
    if (event.key === 'Escape') closeMobileMenu();
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
    document.addEventListener('keydown', handleEscapeKey);

    if (window.location.hash) {
        const anchor = window.location.hash.substring(1);
        setTimeout(() => smoothScroll(anchor), 100);
    }
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
    document.removeEventListener('keydown', handleEscapeKey);
});

const logout = () => {
    router.post(route('logout'));
};
</script>

<style>
@import url('https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css');

.font-\[\'Pacifico\'\] {
    font-family: 'Pacifico', cursive;
}

@media (min-width: 768px) {
    .container {
        max-width: 1280px;
    }
}

button:focus-visible {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
}

.v-enter-active,
.v-leave-active {
    transition: opacity 0.3s, transform 0.3s;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}

section {
    scroll-margin-top: 80px;
}

.ri-menu-line,
.ri-close-line {
    font-size: 1.5rem;
}

.md\:hidden.bg-white.shadow-lg {
    position: absolute;
    width: 100%;
    left: 0;
    top: 100%;
    z-index: 99;
}
</style>
