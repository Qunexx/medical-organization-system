<template>
    <MainLayout>
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-sm mb-12">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ service.name }}</h1>
                    <p class="text-gray-600 whitespace-pre-line mb-8">{{ service.description }}</p>
                    <div class="border-t pt-8">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Специалисты</h2>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div v-for="doctor in service.doctors" :key="doctor.id"
                                 class="bg-gray-50 p-6 rounded-lg hover:bg-white transition-all">
                                <div class="flex items-start gap-4">
                                    <img :src="doctor.user.avatar?.url
                                        ? `/storage/${doctor.user.avatar.url}`
                                        : '/storage/emptyAvatar.jpg'"
                                         class="w-24 h-24 rounded-full object-cover border-2 border-white shadow-sm"
                                         alt="Фото врача">
                                    <div class="flex-1">
                                        <h3 class="text-xl font-semibold text-gray-800">
                                            {{ doctor.user.last_name}} {{ doctor.user.first_name}} {{ doctor.user.middle_name || ''}}
                                        </h3>
                                        <div class="flex items-center gap-2 mb-2">
                                            <i class="ri-briefcase-line text-primary"></i>
                                            <span class="text-gray-600">
                                                Опыт: {{ doctor.years_of_experience || '' }} лет
                                            </span>
                                        </div>
                                        <div class="flex items-start gap-2">
                                            <i class="ri-stethoscope-line text-primary mt-1"></i>
                                            <div>
                                                <p class="text-gray-600 font-medium mb-1">Специализация:</p>
                                                <ul class="list-disc list-inside">
                                                    <li v-for="spec in doctor.specializations"
                                                        :key="spec.id"
                                                        class="text-gray-600">
                                                        {{ spec.name }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <Link :href="route('services.index')"
                                              class="mt-4 inline-flex items-center text-primary hover:underline">
                                            Записаться на прием
                                            <i class="ri-arrow-right-line ml-2"></i>
                                        </Link>
                                    </div>
                                </div>
                            </div>

                            <div v-if="service.doctors.length === 0" class="text-gray-500 col-span-full">
                                На данный момент нет доступных специалистов
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <Link :href="route('services.index')"
                          class="inline-flex items-center px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition">
                        <i class="ri-arrow-left-line mr-2"></i>
                        Назад к списку услуг
                    </Link>
                </div>
            </div>
        </section>
    </MainLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import MainLayout from "@/layouts/MainLayout.vue";

defineProps({
    service: {
        type: Object,
        required: true,
        default: () => ({
            doctors: []
        })
    }
})
</script>
