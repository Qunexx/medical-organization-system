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
                        <Link    :href="route('doctors.show',doctor.id)">
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

                            <Link
                                :href="route('home') + `#appointment`"
                                class="text-primary font-medium hover:underline text-sm flex items-center">
                                Записаться на прием
                                <i class="ri-arrow-right-line ml-1"></i>
                            </Link>

                            <Link
                                :href="route('doctors.show',doctor.id)"
                                class="text-primary font-medium hover:underline text-sm flex items-center">
                                Подробнее
                                <i class="ri-arrow-right-line ml-1"></i>
                            </Link>
                        </div>
                        </Link>
                    </div>
                </div>

                <div class="mt-8 flex justify-center">
                    <nav class="flex gap-2">
                        <Link
                            v-for="(link, index) in doctors.links"
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

<script setup>
import { Link } from '@inertiajs/vue3'
import MainLayout from '../layouts/MainLayout.vue'


defineProps({
    doctors: Object
})
</script>
