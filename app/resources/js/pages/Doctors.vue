<template>
    <MainLayout>
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Наши специалисты</h2>
                    <p class="text-gray-600 max-w-3xl mx-auto">Команда высококвалифицированных врачей с многолетним опытом работы</p>
                </div>

                <div class="grid md:grid-cols-4 gap-6">
                    <div v-for="doctor in doctors.data" :key="doctor.id"
                         class="bg-white rounded-lg shadow-sm hover:shadow-md transition overflow-hidden">
                        <img :src="doctor.user.avatar?.url
                                        ? `/storage/${doctor.user.avatar.url}`
                                        : '/storage/emptyAvatar.jpg'"
                             class="w-24 h-24 rounded-full object-cover border-2 border-white shadow-sm"
                             alt="Фото врача">

                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800">
                                {{ doctor.user.last_name }}
                                {{ doctor.user.first_name }}
                                {{ doctor.user.middle_name }}
                            </h3>

                            <div class="text-primary font-medium mb-2">
                                <span v-for="spec in doctor.specializations"
                                      :key="spec.id"
                                      class="mr-2">
                                    {{ spec.name }}
                                </span>
                            </div>

                            <p class="text-gray-600 text-sm mb-3">
                                Стаж работы: {{ doctor.years_of_experience }} лет
                            </p>

                            <Link :href="route('doctors.show', doctor.id)"
                                  class="text-primary font-medium hover:underline text-sm flex items-center">
                                Записаться на прием
                                <i class="ri-arrow-right-line ml-1"></i>
                            </Link>
                        </div>
                    </div>
                </div>

                <div class="mt-10 text-center" v-if="doctors.links.length > 3">
                    <nav class="flex gap-1 justify-center">
                        <Link
                            v-for="(link, index) in doctors.links"
                            :key="index"
                            :href="link.url || '#'"
                            class="px-3 py-2 rounded-md text-sm font-medium transition-colors"
                            :class="{
                                'bg-primary text-white hover:bg-primary-dark': link.active,
                                'text-gray-500 hover:bg-gray-100': !link.active && link.url,
                                'text-gray-300 cursor-not-allowed': !link.url,
                                'hidden md:inline-block': index !== 0 && index !== doctors.links.length - 1
                            }"
                            preserve-scroll
                            v-html="link.label"
                        />
                    </nav>
                </div>
            </div>
        </section>
    </MainLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import MainLayout from '../layouts/MainLayout.vue'


defineProps({
    doctors: Object
})
</script>
