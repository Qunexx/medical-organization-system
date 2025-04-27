<!-- resources/js/Components/DashboardCard.vue -->
<template>
    <div
        class="p-6 bg-white rounded-xl shadow-sm transition-all duration-200 hover:shadow-md"
        :class="{
      'border-l-4 border-primary': variant === 'primary',
      'border-l-4 border-green-500': variant === 'success',
      'border-l-4 border-red-500': variant === 'danger',
      'border-l-4 border-blue-500': variant === 'info'
    }"
    >
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">{{ title }}</p>
                <p class="text-2xl font-semibold text-gray-900">
                    {{ value }}
                </p>
            </div>
            <div
                class="p-3 rounded-lg bg-opacity-10"
                :class="iconContainerClasses"
            >
                <i :class="icon" class="text-xl"></i>
            </div>
        </div>
        <div v-if="$slots.default" class="mt-4">
            <slot />
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    value: {
        type: [String, Number],
        default: '-'
    },
    icon: {
        type: String,
        required: true
    },
    variant: {
        type: String,
        default: 'primary',
        validator: (value: string) =>
            ['primary', 'success', 'danger', 'info'].includes(value)
    }
});

const iconContainerClasses = computed(() => {
    return {
        'bg-primary': props.variant === 'primary',
        'bg-green-500': props.variant === 'success',
        'bg-red-500': props.variant === 'danger',
        'bg-blue-500': props.variant === 'info'
    };
});
</script>
