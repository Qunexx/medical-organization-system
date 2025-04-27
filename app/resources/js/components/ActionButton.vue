<!-- resources/js/Components/ActionButton.vue -->
<template>
    <button
        @click="$emit('click')"
        class="flex flex-col items-center justify-center p-4 w-full h-full rounded-lg border-2 border-dashed hover:border-solid transition-all duration-200 group"
        :class="[
      variantClasses,
      {'cursor-pointer hover:bg-gray-50': !disabled},
      {'opacity-50 cursor-not-allowed': disabled}
    ]"
        :disabled="disabled"
    >
        <i
            :class="icon"
            class="text-2xl mb-2 transition-colors duration-200"
        ></i>
        <span
            class="text-sm font-medium text-center break-words"
            :class="textClasses"
        >
      {{ label }}
    </span>
    </button>
</template>

<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps({
    label: {
        type: String,
        required: true
    },
    icon: {
        type: String,
        required: true
    },
    variant: {
        type: String,
        default: 'primary',
        validator: (value: string) =>
            ['primary', 'secondary', 'success', 'danger', 'warning', 'info'].includes(value)
    },
    disabled: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['click']);

const variantClasses = computed(() => {
    return {
        'primary': 'border-primary text-primary hover:bg-primary/5',
        'secondary': 'border-gray-300 text-gray-700 hover:bg-gray-50',
        'success': 'border-green-500 text-green-700 hover:bg-green-50',
        'danger': 'border-red-500 text-red-700 hover:bg-red-50',
        'warning': 'border-yellow-500 text-yellow-700 hover:bg-yellow-50',
        'info': 'border-blue-500 text-blue-700 hover:bg-blue-50'
    }[props.variant];
});

const iconClasses = computed(() => {
    return {
        'primary': 'group-hover:text-primary-dark',
        'secondary': 'group-hover:text-gray-800',
        'success': 'group-hover:text-green-800',
        'danger': 'group-hover:text-red-800',
        'warning': 'group-hover:text-yellow-800',
        'info': 'group-hover:text-blue-800'
    }[props.variant];
});

const textClasses = computed(() => {
    return {
        'primary': 'text-primary',
        'secondary': 'text-gray-700',
        'success': 'text-green-700',
        'danger': 'text-red-700',
        'warning': 'text-yellow-700',
        'info': 'text-blue-700'
    }[props.variant];
});
</script>
