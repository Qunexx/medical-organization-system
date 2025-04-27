<!-- components/layouts/Sidebar.vue -->
<template>
    <aside class="w-64 bg-white shadow-md hidden md:block flex-shrink-0">
        <div class="p-4 border-b">
            <Link :href="route('home')" class="text-2xl font-logo text-primary">
                МедИнформСистем
            </Link>
        </div>
        <nav class="mt-4">
            <ul class="flex flex-col h-full">
                <NavItem
                    v-for="item in menuItems"
                    :key="item.route"
                    :href="route(item.route)"
                    :icon="item.icon"
                    :active="route().current(item.route)"
                >
                    {{ item.label }}
                </NavItem>

                <li class="mt-auto border-t pt-2">
                    <NavItem
                        href="/"
                        icon="ri-arrow-left-line"
                        label="На главный сайт"
                    />
                    <NavItem
                        :href="route('logout')"
                        method="post"
                        as="button"
                        icon="ri-logout-box-r-line"
                        label="Выход"
                    />
                </li>
            </ul>
        </nav>
    </aside>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import NavItem from '@/components/NavItem.vue';

const menuItems = [
    { route: 'dashboard', icon: 'ri-dashboard-line', label: 'Обзор' },
    { route: 'profile.edit', icon: 'ri-user-line', label: 'Профиль' },
    { route: 'appointments', icon: 'ri-calendar-check-line', label: 'Мои записи' },
    { route: 'notifications', icon: 'ri-notification-line', label: 'Уведомления' },
];
</script>

<style>
.font-logo {
    font-family: 'Pacifico', cursive;
}
</style>
