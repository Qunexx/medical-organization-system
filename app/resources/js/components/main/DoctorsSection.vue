<template>
    <section id="doctors" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Наши специалисты</h2>
                <p class="text-gray-600 max-w-3xl mx-auto">Команда высококвалифицированных врачей с многолетним опытом работы</p>
            </div>
            <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-6">
                <div v-for="doctor in doctors.slice(0, 6)" :key="doctor.id"
                     class="bg-white rounded-lg shadow-sm hover:shadow-md transition overflow-hidden">
                    <img :src="doctor.user.avatar?.url
                             ? `/storage/${doctor.user.avatar.url}`
                             : '/storage/emptyAvatar.jpg'"
                         class="w-full h-64 object-cover object-top"
                         :alt="`Фото доктора ${doctor.user.last_name}`">
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
                </div>
            </div>
            <div class="mt-10 text-center">
                <Link :href="route('doctors.index')"
                      class="bg-primary text-white px-6 py-3 rounded-button font-medium hover:bg-blue-600 transition inline-block whitespace-nowrap">
                    Все специалисты
                </Link>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'

defineProps({
    doctors: {
        type: Array,
        required: true,
        default: () => []
    }
})
</script>
