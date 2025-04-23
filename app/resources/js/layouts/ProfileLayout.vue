<template>
    <div class="min-h-screen flex bg-gray-100">
        <aside class="w-64 bg-white shadow-md hidden md:block flex-shrink-0">
            <div class="p-4 border-b">
                <Link :href="route('dashboard.index')" class="text-2xl font-['Pacifico'] text-primary">
                    МедЦентр
                </Link>
            </div>
            <nav class="mt-4">
                <ul class="flex flex-col h-full"> {/* Added flex flex-col h-full */}
                    <li>
                        <Link
                            :href="route('home')"
                            class="nav-link"
                            :class="{ 'nav-link-active': route().current('home') }"
                        >
                            <i class="ri-dashboard-line mr-2"></i> Обзор
                        </Link>
                    </li>
                    <li>
                        <Link
                            :href="route('dashboard.profile')"
                            class="nav-link"
                            :class="{ 'nav-link-active': route().current('dashboard.profile') }"
                        >
                            <i class="ri-user-line mr-2"></i> Профиль
                        </Link>
                    </li>
                    <li>
                        <Link
                            :href="route('dashboard.appointments')" {/* Updated href */}
                        class="nav-link"
                        :class="{ 'nav-link-active': route().current('dashboard.appointments') }"
                        >
                        <i class="ri-calendar-check-line mr-2"></i> Мои записи
                        </Link>
                    </li>
                    <li>
                        <Link href="#" class="nav-link nav-link-disabled">
                            <i class="ri-file-list-3-line mr-2"></i> Медкарта (скоро)
                        </Link>
                    </li>
                    {/* Перемещаем ссылки "На главный сайт" и "Выход" вниз */}
                    <li class="mt-auto border-t pt-2"> {/* Added mt-auto */}
                        <Link href="/" class="nav-link">
                            <i class="ri-arrow-left-line mr-2"></i> На главный сайт
                        </Link>
                        <Link :href="route('logout')" method="post" as="button" class="nav-link w-full text-left"> {/* Added w-full text-left for button styling */}
                            <i class="ri-logout-box-r-line mr-2"></i> Выход
                        </Link>
                    </li>
                </ul>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="bg-white shadow-sm p-4 flex justify-between items-center">
                <div></div>
                <div class="flex items-center">
                    <span class="mr-4 text-gray-700">Здравствуйте, {{ $page.props.auth.user.name }}!</span>
                    <Link :href="route('logout')" method="post" as="button" class="md:hidden text-gray-600 hover:text-primary">
                        <i class="ri-logout-box-r-line ri-lg"></i>
                    </Link>
                </div>
            </header>

            <main class="flex-1 p-6">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
// NavLink больше не импортируется

// Получаем данные аутентифицированного пользователя
const page = usePage();
// const authUser = page.props.auth?.user; // Можно использовать $page.props.auth.user напрямую в шаблоне
</script>

<style scoped>
.font-\[\'Pacifico\'\] {
    font-family: 'Pacifico', cursive;
}

/* Общие стили для навигационных ссылок */
.nav-link {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem; /* 12px 16px */
    color: #4b5563; /* text-gray-600 */
    transition: background-color 0.2s, color 0.2s;
    border-left: 3px solid transparent; /* Добавляем место для индикатора */
}
.nav-link:hover {
    background-color: #f3f4f6; /* bg-gray-100 */
    color: #3b82f6; /* text-primary */
    border-left-color: #d1d5db; /* bg-gray-300 - индикатор при наведении */
}

/* Стили для активной ссылки */
.nav-link-active {
    background-color: #eff6ff; /* bg-blue-50 */
    color: #3b82f6; /* text-primary */
    font-weight: 600; /* font-semibold */
    border-left-color: #3b82f6; /* text-primary - Яркий индикатор */
}

/* Стили для неактивной/будущей ссылки */
.nav-link-disabled {
    color: #9ca3af; /* text-gray-400 */
    cursor: not-allowed;
    pointer-events: none; /* Отключаем клики */
}
.nav-link-disabled:hover { /* Убираем ховер-эффекты для неактивных */
    background-color: transparent;
    color: #9ca3af;
    border-left-color: transparent;
}

/* Стили для кнопки Выход, чтобы она выглядела как ссылка */
.nav-link[as="button"] {
    background: none;
    border: none;
    cursor: pointer;
}
.nav-link[as="button"]:hover {
    /* Стили ховера как у обычной ссылки */
    background-color: #f3f4f6;
    color: #3b82f6;
    border-left-color: #d1d5db;
}
</style>
