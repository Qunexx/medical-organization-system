<!-- resources/js/Pages/Patient/Appointments/Index.vue -->
<template>
    <ProfileLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight ml-6">
                Мои записи
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Дата</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Врач</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Специальность</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Действия</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            <tr
                                v-for="appointment in appointments.data"
                                :key="appointment.id"
                                class="hover:bg-gray-50"
                            >
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ formatDate(appointment.appointment_date) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ appointment.doctor.user.first_name }} {{ appointment.doctor.user.second_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ appointment.specialization.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                    <span
                        class="px-2 py-1 text-sm rounded-full"
                        :class="statusClasses(appointment.status)"
                    >
                      {{ statusText(appointment.status) }}
                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                    <Link
                                        :href="route('patient.appointment.view', appointment.id)"
                                        class="text-primary hover:text-primary-dark"
                                    >
                                        Детали
                                    </Link>
                                    <button
                                        v-if="canCancel(appointment)"
                                        @click="cancelAppointment(appointment)"
                                        class="text-red-600 hover:text-red-800"
                                    >
                                        Отменить
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Пагинация -->
                    <Pagination
                        :links="appointments.links"
                        class="p-4"
                    />
                </div>
            </div>
        </div>
    </ProfileLayout>
</template>

<script setup lang="ts">
import ProfileLayout from '../../layouts/ProfileLayout.vue';
import Pagination from '../../components/Pagination.vue';
import { router, Link } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    appointments: Object,
    filters: Object,
});

const filters = ref({
    status: props.filters.status || '',
    date: props.filters.date || ''
});

const statusMap = {
    1: { text: 'Принята', class: 'bg-green-100 text-green-800' },
    2: { text: 'Отменена', class: 'bg-red-100 text-red-800' },
    3: { text: 'Подтверждена', class: 'bg-blue-100 text-blue-800' },
    4: { text: 'Не подтверждена', class: 'bg-yellow-100 text-yellow-800' },
    5: { text: 'Завершена', class: 'bg-gray-100 text-gray-800' },
};

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('ru-RU', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

watch(filters, value => {
    router.get(route('appointments.index'), {
        status: value.status,
        date: value.date
    }, {
        preserveState: true,
        preserveScroll: true,
        replace: true
    });
});

const statusClasses = (statusValue: number) => {
    return statusMap[statusValue]?.class || 'bg-gray-100 text-gray-800';
};

const statusText = (statusValue: number) => {
    return statusMap[statusValue]?.text || 'Неизвестно';
};

const canCancel = (appointment: any) => {
    return [1, 3].includes(appointment.status);
};

const cancelAppointment = (appointment: any) => {
    if (confirm('Вы уверены, что хотите отменить запись?')) {
        router.delete(route('appointments.destroy', appointment.id));
    }
};
</script>
