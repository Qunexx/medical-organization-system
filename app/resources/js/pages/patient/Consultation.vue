<template>
    <ProfileLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight ml-6">
                Детали записи №{{ appointment.id }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Дата и время приема:</label>
                                <p class="mt-1 text-lg text-gray-900">
                                    {{ formatDateTime(appointment.appointment_date) }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Статус:</label>
                                <span
                                    class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                                    :class="statusClasses(appointment.status)"
                                >
                                    {{ statusText(appointment.status) }}
                                </span>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <h3 class="text-lg font-medium mb-2">Информация о враче</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-500">ФИО врача:</label>
                                    <p class="font-medium">
                                        {{ appointment.doctor.user.first_name }}
                                        {{ appointment.doctor.user.last_name }}
                                        {{ appointment.doctor.user.middle_name }}
                                    </p>
                                    <Link
                                        :href="route('doctors.show', appointment.doctor_id)"
                                        class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition"
                                    >
                                        ← Детали врача
                                    </Link>
                                </div>

                                <div>
                                    <label class="block text-sm text-gray-500">Специализация:</label>
                                    <p class="font-medium">
                                        {{ appointment.specialization.name }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <h3 class="text-lg font-medium mb-2">Детали записи</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm text-gray-500">Ваш комментарий:</label>
                                    <p class="whitespace-pre-wrap">
                                        {{ appointment.patient_comment || 'Не заполнено' }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm text-gray-500">Заключение врача:</label>
                                    <p class="whitespace-pre-wrap">
                                        {{ appointment.conclusion || 'Не заполнено' }}
                                    </p>
                                </div>

                                <div v-if="appointment.cancel_reason">
                                    <label class="block text-sm text-gray-500">Причина отмены:</label>
                                    <p class="text-red-600">{{ appointment.cancel_reason }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="border-t pt-4" v-if="appointment.status === 5">
                            <div v-if="!appointment.review" class="space-y-4">
                            <h3 class="text-lg font-medium mb-4">Оставить отзыв</h3>

                                <form @submit.prevent="submitReview">
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Комментарий:</label>
                                        <textarea
                                            v-model="form.comment"
                                            rows="4"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="Опишите ваши впечатления о приеме..."
                                            required
                                        ></textarea>
                                    </div>

                                    <div class="flex gap-4">
                                        <button
                                            type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition"
                                            :disabled="form.processing"
                                        >
                                            Отправить отзыв
                                        </button>

                                        <button
                                            type="button"
                                            @click="cancelReview"
                                            class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition"
                                        >
                                            Отмена
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div v-else class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium mb-2">Ваш отзыв:</h4>
                                <p class="whitespace-pre-wrap">{{ appointment.review.text }}</p>
                            </div>
                        </div>

                        <div class="border-t pt-6 flex justify-between items-center">
                            <Link
                                :href="route('patient.myConsultation')"
                                class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition"
                            >
                                ← Назад к списку
                            </Link>

                            <button
                                v-if="canCancel(appointment)"
                                @click="cancelAppointment(appointment)"
                                class="inline-flex items-center px-4 py-2 bg-red-100 border border-transparent rounded-md font-semibold text-red-700 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition"
                            >
                                Отменить запись
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </ProfileLayout>
</template>

<script setup lang="ts">
import ProfileLayout from '../../layouts/ProfileLayout.vue';
import {Link, router, useForm} from '@inertiajs/vue3';

const props = defineProps({
    appointment: Object
});

const statusMap = {
    1: { text: 'Принята', class: 'bg-green-100 text-green-800' },
    2: { text: 'Отменена', class: 'bg-red-100 text-red-800' },
    3: { text: 'Подтверждена', class: 'bg-blue-100 text-blue-800' },
    4: { text: 'Не подтверждена', class: 'bg-yellow-100 text-yellow-800' },
    5: { text: 'Завершена', class: 'bg-gray-100 text-gray-800' },
};

const formatDateTime = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('ru-RU', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

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
    if (confirm('Вы уверены, что хотите отменить эту запись?')) {
        router.post(route('patient.appointment.delete', appointment.id));
    }
};

const form = useForm({
    comment: '',
    appointment_id: props.appointment.id,
});

const submitReview = () => {
    form.post(route('patient.appointment.review', props.appointment.id), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            router.reload({ only: ['appointment'] });
        },
        onError: (errors) => {
            console.error('Ошибка отправки отзыва:', errors);
        }
    });
};

const cancelReview = () => {
    form.reset();
};
</script>

<style scoped>
.whitespace-pre-wrap {
    white-space: pre-wrap;
}
</style>
