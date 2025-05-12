<template>
    <section id="services" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Наши услуги</h2>
                <p class="text-gray-600 max-w-3xl mx-auto">Мы предлагаем широкий спектр медицинских услуг для поддержания вашего здоровья</p>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div v-for="service in services" :key="service.id" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ service.name }}</h3>
                    <p class="text-gray-600 mb-4">{{ service.description }}</p>
                    <Link :href="route('services.show', service.id)" class="text-primary font-medium hover:underline flex items-center">
                        Подробнее
                        <i class="ri-arrow-right-line ml-1"></i>
                    </Link>
                </div>
            </div>
            <div class="mt-10 text-center">
                <Link :href="route('services.index')" class="bg-primary text-white px-6 py-3 !rounded-button font-medium hover:bg-blue-600 transition inline-block whitespace-nowrap">
                    Все услуги
                </Link>
            </div>
        </div>
    </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    services: Array
})
</script>
