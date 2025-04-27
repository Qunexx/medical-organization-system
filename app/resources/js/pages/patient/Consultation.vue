<!-- resources/js/Pages/Patient/Appointments/Index.vue -->
<template>
    <ProfileLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Мои записи
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <select
                                v-model="filters.status"
                                class="border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary"
                            >
                                <option value="">Все статусы</option>
                                <option value="pending">Ожидание</option>
                                <option value="confirmed">Подтверждено</option>
                                <option value="completed">Завершено</option>
                                <option value="canceled">Отменено</option>
                            </select>

                            <input
                                type="date"
                                v-model="filters.date"
                                class="border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary"
                            >
                        </div>
                    </div>

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
                                    {{ formatDate(appointment.date) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ appointment.doctor.full_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ appointment.doctor.specialization }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                    <span
                        class="px-2 py-1 text-sm rounded-full"
                        :class="statusClasses(appointment.status)"
                    >
                      {{ statusText(appointment.status) }}
                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
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
                        :links="links"
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
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    appointments: Object,
    filters: Object,
    links: Object,
});

const filters = ref({
    status: props.filters.status || '',
    date: props.filters.date || ''
});

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('ru-RU', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const statusClasses = (status: string) => {
    const classes = {
        pending: 'bg-yellow-100 text-yellow-800',
        confirmed: 'bg-green-100 text-green-800',
        completed: 'bg-blue-100 text-blue-800',
        canceled: 'bg-red-100 text-red-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};

const statusText = (status: string) => {
    const texts = {
        pending: 'Ожидание',
        confirmed: 'Подтверждено',
        completed: 'Завершено',
        canceled: 'Отменено'
    };
    return texts[status] || 'Неизвестно';
};

const canCancel = (appointment: any) => {
    return ['pending', 'confirmed'].includes(appointment.status);
};

const cancelAppointment = (appointment: any) => {
    if (confirm('Вы уверены, что хотите отменить запись?')) {
        router.delete(route('appointments.destroy', appointment.id));
    }
};
</script>
