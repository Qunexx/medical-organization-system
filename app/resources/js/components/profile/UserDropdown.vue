<!-- components/UserDropdown.vue -->
<template>
    <div class="relative">
        <button
            @click="toggleDropdown"
            class="flex items-center space-x-2 focus:outline-none"
        >
            <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center">
                {{ userInitials }}
            </div>
            <i class="ri-arrow-down-s-line"></i>
        </button>

        <div
            v-show="showDropdown"
            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
        >
            <Link
                :href="route('profile.edit')"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
            >
                Профиль
            </Link>
            <Link
                :href="route('logout')"
                method="post"
                as="button"
                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
            >
                Выход
            </Link>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

const page = usePage();
const showDropdown = ref(false);

const userInitials = computed(() => {
    const user = page.props.auth.user;
    return (user.first_name[0] + (user.last_name?.[0] || '')).toUpperCase();
});

const toggleDropdown = () => {
    showDropdown.value = !showDropdown.value;
};
</script>
