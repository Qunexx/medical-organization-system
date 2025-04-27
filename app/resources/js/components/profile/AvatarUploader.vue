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
                :src="avatarUrl"
                class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-xl"
                :class="{ 'ring-4 ring-primary': isHovered }"
            />

            <div
                v-if="uploadProgress > 0"
                class="absolute inset-0 rounded-full bg-black/50 flex items-center justify-center"
            >
                <span class="text-white font-bold text-lg">
                    {{ uploadProgress }}%
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
                @click="showFilePicker"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50"
            >
                <i class="ri-upload-cloud-2-line"></i>
                <span>Изменить фото</span>
            </button>


            <p class="text-sm text-gray-500 text-center">
                Поддерживаемые форматы: JPG, PNG, GIF<br>
                Максимальный размер: 5MB
            </p>
        </div>

        <div
            v-if="isUploading"
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
                        :style="{ width: `${uploadProgress}%` }"
                    ></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    user: Object
});

const fileInput = ref<HTMLInputElement | null>(null);
const uploadProgress = ref(0);
const isHovered = ref(false);
const isUploading = ref(false);

const avatarUrl = computed(() =>
    props.user?.avatar_url || '/images/default-avatar.jpg'
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
        return;
    }

    isUploading.value = true;
    const form = useForm({
        avatar: file
    });

    try {
        await form.post(route('avatar.update'), {
            onUploadProgress: (progressEvent) => {
                if (progressEvent.total) {
                    uploadProgress.value = Math.round(
                        (progressEvent.loaded * 100) / progressEvent.total
                    );
                }
            }
        });
    } catch (error) {
        alert('Ошибка загрузки! Попробуйте другой файл');
    } finally {
        isUploading.value = false;
        uploadProgress.value = 0;
        if (input) input.value = '';
    }
};
</script>

<style scoped>
.animate-spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>
