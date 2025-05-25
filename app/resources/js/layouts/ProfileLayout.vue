<template>
    <div class="min-h-screen flex bg-gray-100">
        <button
            @click="toggleMobileMenu"
            class="md:hidden fixed top-4 left-4 z-50 p-2 rounded-lg bg-white shadow-lg text-gray-600 hover:text-primary"
            :aria-expanded="isMobileMenuOpen"
        >
            <i class="ri-lg" :class="isMobileMenuOpen ? 'ri-close-line' : 'ri-menu-line'"></i>
        </button>

        <aside class="w-64 bg-white shadow-md hidden md:block flex-shrink-0">
            <div class="p-4 border-b">
                <Link :href="route('home')" class="text-2xl font-['Pacifico'] text-primary">
                    МедИнформСистем
                </Link>
            </div>
            <nav class="mt-4">
                <ul class="flex flex-col h-full">
                    <li>
                        <Link
                            :href="route('patient.index')"
                            class="nav-link"
                            :class="{ 'nav-link-active': route().current('patient.index') }"
                        >
                            <i class="ri-dashboard-line mr-2"></i> Обзор
                        </Link>
                    </li>
                    <li>
                        <Link
                            :href="route('patient.profile')"
                            class="nav-link"
                            :class="{ 'nav-link-active': route().current('patient.profile') }"
                        >
                            <i class="ri-user-line mr-2"></i> Профиль
                        </Link>
                    </li>
                    <li>
                        <Link
                            :href="route('patient.myConsultation')"
                            class="nav-link"
                            :class="{ 'nav-link-active': route().current('patient.myConsultation') }"
                        >
                            <i class="ri-calendar-check-line mr-2"></i> Мои записи
                        </Link>
                    </li>
                    <li>
                        <Link
                            :href="route('patient.notification')"
                            class="nav-link"
                            :class="{ 'nav-link-active': route().current('patient.notification') }"
                        >
                            <i class="ri-notification-line mr-2"></i> Уведомления
                        </Link>
                    </li>
                    <li>
                        <Link
                            :href="route('patient.changePasswordView')"
                            class="nav-link"
                            :class="{ 'nav-link-active': route().current('patient.changePasswordView') }"
                        >
                            <i class="ri-lock-password-line mr-2"></i> Смена пароля
                        </Link>
                    </li>
                    <li>
                        <Link href="#" class="nav-link nav-link-disabled">
                            <i class="ri-file-list-3-line mr-2"></i> Медкарта (скоро)
                        </Link>
                    </li>
                    <li class="mt-auto border-t pt-2">
                        <Link href="/" class="nav-link">
                            <i class="ri-arrow-left-line mr-2"></i> На главный сайт
                        </Link>
                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="nav-link w-full text-left"
                        >
                            <i class="ri-logout-box-r-line mr-2"></i> Выход
                        </Link>
                    </li>
                </ul>
            </nav>
        </aside>

        <Transition
            enter-active-class="transition-transform duration-300 ease-out"
            leave-active-class="transition-transform duration-200 ease-in"
            enter-from-class="-translate-x-full"
            leave-to-class="-translate-x-full"
        >
            <aside
                v-show="isMobileMenuOpen"
                class="w-64 bg-white shadow-md fixed inset-y-0 left-0 z-40 overflow-y-auto"
            >
                <div class="p-4 border-b">
                    <Link :href="route('home')" class="text-2xl font-['Pacifico'] text-primary">
                        МедИнформСистем
                    </Link>
                </div>
                <nav class="mt-4">
                    <ul class="flex flex-col h-full">
                        <li>
                            <Link
                                @click="closeMobileMenu"
                                :href="route('patient.index')"
                                class="nav-link"
                                :class="{ 'nav-link-active': route().current('patient.index') }"
                            >
                                <i class="ri-dashboard-line mr-2"></i> Обзор
                            </Link>
                        </li>
                        <li>
                            <Link
                                @click="closeMobileMenu"
                                :href="route('patient.profile')"
                                class="nav-link"
                                :class="{ 'nav-link-active': route().current('patient.profile') }"
                            >
                                <i class="ri-user-line mr-2"></i> Профиль
                            </Link>
                        </li>
                        <li>
                            <Link
                                @click="closeMobileMenu"
                                :href="route('patient.myConsultation')"
                                class="nav-link"
                                :class="{ 'nav-link-active': route().current('patient.myConsultation') }"
                            >
                                <i class="ri-calendar-check-line mr-2"></i> Мои записи
                            </Link>
                        </li>
                        <li>
                            <Link
                                @click="closeMobileMenu"
                                :href="route('patient.notification')"
                                class="nav-link"
                                :class="{ 'nav-link-active': route().current('patient.notification') }"
                            >
                                <i class="ri-notification-line mr-2"></i> Уведомления
                            </Link>
                        </li>
                        <li>
                            <Link
                                @click="closeMobileMenu"
                                :href="route('patient.changePasswordView')"
                                class="nav-link"
                                :class="{ 'nav-link-active': route().current('patient.changePasswordView') }"
                            >
                                <i class="ri-lock-password-line mr-2"></i> Смена пароля
                            </Link>
                        </li>
                        <li>
                            <Link
                                href="#"
                                @click="closeMobileMenu"
                                class="nav-link nav-link-disabled"
                            >
                                <i class="ri-file-list-3-line mr-2"></i> Медкарта (скоро)
                            </Link>
                        </li>
                        <li class="mt-auto border-t pt-2">
                            <Link
                                href="/"
                                @click="closeMobileMenu"
                                class="nav-link"
                            >
                                <i class="ri-arrow-left-line mr-2"></i> На главный сайт
                            </Link>
                            <Link
                                :href="route('logout')"
                                method="post"
                                as="button"
                                class="nav-link w-full text-left"
                                @click="closeMobileMenu"
                            >
                                <i class="ri-logout-box-r-line mr-2"></i> Выход
                            </Link>
                        </li>
                    </ul>
                </nav>
            </aside>
        </Transition>

        <div class="flex-1 flex flex-col">
            <header class="bg-white shadow-sm p-4 flex justify-between items-center">
                <div class="flex-1"></div>
                <div class="flex items-center gap-4">
                    <span class="text-gray-700">
                        Здравствуйте, {{ $page.props.auth.user.first_name }}!
                    </span>
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="md:hidden text-gray-600 hover:text-primary"
                    >
                        <i class="ri-logout-box-r-line ri-lg"></i>
                    </Link>
                </div>
            </header>

            <main class="flex-1 bg-gray-50">
                <slot name="header" />
                <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
                    <slot />
                </div>
            </main>
        </div>

        <Transition
            enter-active-class="transition-opacity duration-300"
            leave-active-class="transition-opacity duration-200"
            enter-from-class="opacity-0"
            leave-to-class="opacity-0"
        >
            <div
                v-show="isMobileMenuOpen"
                @click="closeMobileMenu"
                class="fixed inset-0 z-30 bg-black/50 md:hidden"
            ></div>
        </Transition>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { Link } from '@inertiajs/vue3';

const isMobileMenuOpen = ref(false);

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const closeMobileMenu = () => {
    isMobileMenuOpen.value = false;
};

const handleClickOutside = (event: MouseEvent) => {
    const sidebar = document.querySelector('aside.fixed');
    const button = document.querySelector('[aria-expanded]');

    if (!sidebar?.contains(event.target as Node) && !button?.contains(event.target as Node)) {
        closeMobileMenu();
    }
};

const handleEscapeKey = (event: KeyboardEvent) => {
    if (event.key === 'Escape') closeMobileMenu();
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
    document.addEventListener('keydown', handleEscapeKey);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
    document.removeEventListener('keydown', handleEscapeKey);
});
</script>

<style scoped>
@import url('https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css');
.font-\[\'Pacifico\'\] {
    font-family: 'Pacifico', cursive;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    color: #4b5563;
    transition: background-color 0.2s, color 0.2s;
    border-left: 3px solid transparent;
}

.nav-link:hover {
    background-color: #f3f4f6;
    color: #3b82f6;
    border-left-color: #d1d5db;
}

.nav-link-active {
    background-color: #eff6ff;
    color: #3b82f6;
    font-weight: 600;
    border-left-color: #3b82f6;
}

.nav-link-disabled {
    color: #9ca3af;
    cursor: not-allowed;
    pointer-events: none;
}

.nav-link-disabled:hover {
    background-color: transparent;
    color: #9ca3af;
    border-left-color: transparent;
}

.enter-active-class {
    transition: transform 0.3s ease-out;
}
.leave-active-class {
    transition: transform 0.2s ease-in;
}
.enter-from-class {
    transform: translateX(-100%);
}
.leave-to-class {
    transform: translateX(-100%);
}

/* Анимации затемнения фона */
.enter-active-class[style*="opacity"] {
    transition: opacity 0.3s;
}
.leave-active-class[style*="opacity"] {
    transition: opacity 0.2s;
}
</style>
