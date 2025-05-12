
<template>
    <MainLayout>
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">Все услуги</h1>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div v-for="service in services.data" :key="service.id" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ service.name }}</h3>
                    <p class="text-gray-600 mb-4">{{ service.description }}</p>
                    <Link :href="route('services.show', service.id)" class="text-primary font-medium hover:underline flex items-center">
                        Подробнее
                        <i class="ri-arrow-right-line ml-1"></i>
                    </Link>
                </div>
            </div>

            <div class="mt-8 flex justify-center">
                <nav class="flex gap-2">
                    <Link
                        v-for="(link, index) in services.links"
                        :key="index"
                        :href="link.url || '#'"
                        class="px-4 py-2 rounded-md"
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
    </section>
    </MainLayout>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import MainLayout from "@/layouts/MainLayout.vue";

defineProps({
    services: Object
})
</script>
