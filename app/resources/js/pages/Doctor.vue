<template>
    <MainLayout>
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-sm">
                    <div class="flex flex-col md:flex-row gap-8 items-start">
                        <img :src="doctor.user.avatar?.url
                                        ? `/storage/${doctor.user.avatar.url}`
                                        : '/storage/emptyAvatar.jpg'"
                             class="w-24 h-24 rounded-full object-cover border-2 border-white shadow-sm"
                             alt="Фото врача">

                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                                {{ doctor.user.last_name }}
                                {{ doctor.user.first_name }}
                                {{ doctor.user.middle_name }}
                            </h1>

                            <div class="mb-4">
                                <span v-for="spec in doctor.specializations"
                                      :key="spec.id"
                                      class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm mr-2">
                                    {{ spec.name }}
                                </span>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-2">Опыт работы</h3>
                                    <p class="text-gray-600">
                                        {{ doctor.years_of_experience }} лет
                                    </p>
                                </div>

                                <div v-if="doctor.services.length">
                                    <h3 class="font-semibold text-gray-800 mb-2">Услуги</h3>
                                    <ul class="list-disc pl-6">
                                        <li v-for="service in doctor.services"
                                            :key="service.id"
                                            class="text-gray-600">
                                            {{ service.name }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <Link
                            :href="route('home') + `#appointment`"
                            class="text-primary font-medium hover:underline text-sm flex items-center">
                            Записаться на прием
                            <i class="ri-arrow-right-line ml-1"></i>
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>

<script setup>
import MainLayout from '../layouts/MainLayout.vue'
import {Link} from "@inertiajs/vue3";

defineProps({
    doctor: Object
})
</script>
