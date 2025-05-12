<template>
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Отзывы наших пациентов</h2>
                <p class="text-gray-600 max-w-3xl mx-auto">Узнайте, что говорят о нас пациенты, которые уже воспользовались нашими услугами</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8" v-if="reviews.length">
                <div
                    class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100"
                    v-for="review in reviews"
                    :key="review.id"
                >
                    <div class="relative mb-6">
                        <span class="absolute -top-4 left-0 text-4xl text-primary-500 font-serif">“</span>
                        <p class="text-gray-700 text-lg pl-8 italic">«{{ review.text }}»</p>
                    </div>

                    <div class="flex items-center border-t pt-4">
                        <div class="w-12 h-12 flex items-center justify-center bg-primary-100 text-primary-600 rounded-full mr-4">
                            <i class="ri-user-3-line text-xl" v-if="!review.user.avatar"></i>
                            <img v-else :src="'storage/' + review.user.avatar.url" class="w-full h-full rounded-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">{{ review.user.first_name || 'Анонимный пациент'  }}</h4>
                            <p class="text-gray-500 text-sm">{{ formatDate(review.created_at) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="text-center py-8">
                <p class="text-gray-500">Пока нет отзывов. Будьте первым!</p>
            </div>

            <div class="mt-10 text-center">
                <Link
                    :href="route('reviews.index')"
                      class="bg-primary text-white px-6 py-3 rounded-button font-medium hover:bg-blue-600 transition inline-block whitespace-nowrap">
                    Все отзывы
                </Link>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    reviews: {
        type: Array,
        required: true,
        default: () => []
    }
});

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('ru-RU', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
};
</script>
