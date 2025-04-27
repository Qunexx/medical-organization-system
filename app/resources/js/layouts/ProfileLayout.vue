<template>
    <div class="min-h-screen flex bg-gray-100">
        <aside class="w-64 bg-white shadow-md hidden md:block flex-shrink-0">
            <div class="p-4 border-b">
                <Link :href="route('home')" class="text-2xl font-['Pacifico'] text-primary">
                    МедЦентр
                </Link>
            </div>
            <nav class="mt-4">
                <ul class="flex flex-col h-full">
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
                            :href="route('home')"
                            class="nav-link"
                            :class="{ 'nav-link-active': route('home') }"
                        >
                            <i class="ri-user-line mr-2"></i> Профиль
                        </Link>
                    </li>
                    <li>
                        <Link
                            :href="route('home')"
                        class="nav-link"
                        :class="{ 'nav-link-active': route('home') }"
                        >
                        <i class="ri-calendar-check-line mr-2"></i> Мои записи
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
                        <Link :href="route('logout')" method="post" as="button" class="nav-link w-full text-left">
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
                    <span class="mr-4 text-gray-700">Здравствуйте, {{ $page.props.auth.user.first_name }}!</span>
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

const page = usePage();
</script>

<style scoped>
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

.nav-link[as="button"] {
    background: none;
    border: none;
    cursor: pointer;
}
.nav-link[as="button"]:hover {
    background-color: #f3f4f6;
    color: #3b82f6;
    border-left-color: #d1d5db;
}
</style>
