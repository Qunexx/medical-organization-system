<template>
    <div class="flex flex-col items-center gap-6">
        <div
            class="relative group transition-all duration-300 hover:scale-105"
            @mouseenter="isHovered = true"
            @mouseleave="isHovered = false"
        >
            <div
                class="absolute inset-0 rounded-full bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer"
                @click="showFilePicker"
            >
                <i class="ri-camera-line text-2xl text-white"></i>
            </div>

            <img
                :src="currentAvatarUrl"
                class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-xl"
                :class="{ 'ring-4 ring-primary': isHovered }"
            />

            <div
                v-if="form.progress"
                class="absolute inset-0 rounded-full bg-black/50 flex items-center justify-center"
            >
                <span class="text-white font-bold text-lg">
                    {{ Math.round(form.progress.percentage) }}%
                </span>
            </div>
        </div>

        <input
            type="file"
            ref="fileInput"
            class="hidden"
            accept="image/*"
            @change="handleFileUpload"
        />

        <div class="flex flex-col items-center gap-4">
            <button
                type="button"
                @click="showFilePicker"
                class="btn-primary"
                :disabled="form.processing"
            >
                <i class="ri-upload-cloud-2-line"></i>
                <span>
                    {{ form.processing ? 'Загрузка...' : 'Изменить фото' }}
                </span>
            </button>

            <p class="text-sm text-gray-500 text-center">
                Поддерживаемые форматы: JPG, PNG, GIF<br>
                Максимальный размер: 5MB
            </p>
        </div>

        <div
            v-if="form.processing"
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        >
            <div class="bg-white p-8 rounded-xl text-center">
                <div class="animate-spin mb-4">
                    <i class="ri-loader-4-line text-4xl text-primary"></i>
                </div>
                <p class="font-medium">Идет загрузка...</p>
                <div class="w-64 h-2 bg-gray-200 rounded-full mt-4">
                    <div
                        class="h-full bg-primary rounded-full transition-all duration-300"
                        :style="{ width: `${Math.round(form.progress?.percentage || 0)}%` }"
                    ></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    avatar_url: string;
}>();

const fileInput = ref<HTMLInputElement | null>(null);
const isHovered = ref(false);
const avatarUrl = ref(props.avatar_url);

const form = useForm({
    avatar: null as File | null,
});

const currentAvatarUrl = computed(() =>
    avatarUrl.value || '/images/default-avatar.jpg'
);

const showFilePicker = () => {
    fileInput.value?.click();
};

const handleFileUpload = async (event: Event) => {
    const input = event.target as HTMLInputElement;
    const file = input.files?.[0];

    if (!file) return;

    if (file.size > 5 * 1024 * 1024) {
        alert('Файл слишком большой! Максимальный размер 5MB');
        input.value = '';
        return;
    }

    try {
        form.avatar = file;

        await form.post(route('patient.avatar.update'), {
            preserveScroll: true,
            preserveState: true,
            forceFormData: true,
            onSuccess: () => {
                avatarUrl.value = form.data.avatar_url || props.avatar_url;
            }
        });
    } finally {
        form.reset();
        input.value = '';
    }
};
</script>

<style scoped>
.btn-primary {
    padding-left: 1rem;
    padding-right: 1rem;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    background-color: rgb(37 99 235);
    color: white;
    border-radius: 0.375rem;
    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
}

.btn-primary:hover {
    background-color: rgb(29 78 216);
}

.btn-primary:focus {
    outline: 2px solid transparent;
    outline-offset: 2px;
    ring-width: 2px;
    ring-color: rgb(59 130 246);
}

.btn-primary:disabled {
    opacity: 0.5;
}


.animate-spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>
