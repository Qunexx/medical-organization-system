<!-- components/NavItem.vue -->
<template>
    <li>
        <Link
            :href="href"
            :method="method"
            :as="as"
            class="nav-link"
            :class="{ 'nav-link-active': active }"
        >
            <i :class="`${icon} mr-2`"></i>
            <slot>{{ label }}</slot>
        </Link>
    </li>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps({
    href: String,
    icon: String,
    label: String,
    active: Boolean,
    method: {
        type: String,
        default: 'get'
    },
    as: {
        type: String,
        default: 'a'
    }
});
</script>
