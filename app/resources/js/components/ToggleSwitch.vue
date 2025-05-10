<template>
    <label class="relative inline-flex items-center cursor-pointer select-none">
        <input
            type="checkbox"
            class="sr-only"
            :checked="modelValue"
            :disabled="disabled"
            @change="$emit('update:modelValue', $event.target.checked)"
        >
        <div
            class="w-11 h-6 rounded-full transition-colors duration-200 relative"
            :class="{
                'bg-blue-600': modelValue && !disabled,
                'bg-gray-400': disabled,
                'bg-gray-200': !modelValue && !disabled,
                'cursor-not-allowed opacity-50': disabled
            }"
        >
            <div
                class="absolute top-0.5 left-0.5 bg-white rounded-full shadow-sm transform transition-transform duration-200"
                :class="{
                    'translate-x-5': modelValue,
                    'translate-x-0': !modelValue
                }"
                style="width: 1.25rem; height: 1.25rem;"
            ></div>
        </div>
    </label>
</template>

<script setup>
defineProps({
    modelValue: {
        type: Boolean,
        default: false
    },
    disabled: {
        type: Boolean,
        default: false
    }
})

defineEmits(['update:modelValue'])
</script>
