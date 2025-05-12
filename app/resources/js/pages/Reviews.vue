<template>
    <MainLayout>
        <section class="py-12 bg-gray-50">
            <div class="container mx-auto px-4 min-h-[calc(100vh-200px)] flex flex-col">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">Все отзывы</h1>
                </div>

                <div v-if="reviews.length" class="space-y-6 flex-1">
                    <div
                        v-for="review in reviews.data"
                        :key="review.id"
                    >
                        <p class="text-gray-700 italic mb-4">
                            "{{ review.text }}"
                        </p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 mr-3">
                                <img
                                    v-if="review.user?.avatar"
                                    :src="`/storage/${review.user.avatar.url}`"
                                    class="w-full h-full rounded-full object-cover border"
                                >
                                <div v-else class="w-full h-full rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="ri-user-line text-primary"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">
                                    {{ review.user?.first_name || 'Анонимный пациент' }}
                                </h4>
                                <p class="text-gray-500 text-sm">
                                    {{ formatDate(review.created_at) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="text-center py-8">
                    <p class="text-gray-500">Пока нет отзывов. Будьте первым!</p>
                </div>
                <div v-if="reviews.length" >
                <div class="mt-8 pb-4">
                    <nav class="flex gap-2 justify-center">
                        <Link
                            v-for="(link, index) in reviews.links"
                            :key="index"
                            :href="link.url || '#'"
                            class="px-3 py-1.5 rounded-md text-sm"
                            :class="{
                                'bg-primary text-white': link.active,
                                'text-gray-500 hover:bg-gray-100': !link.active && link.url,
                                'text-gray-400 cursor-not-allowed': !link.url
                            }"
                            v-html="link.label"
                        />
                    </nav>
                </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import MainLayout from '../layouts/MainLayout.vue';

const props = defineProps({
    reviews: Object
});

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('ru-RU', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    });
};
</script>
