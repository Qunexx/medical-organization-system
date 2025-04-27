<!-- resources/js/Pages/Dashboard/Index.vue -->
<template>
    <Head title="Обзор" />

    <ProfileLayout>
        <template #header>
            <div class="space-y-2">
                <h3 class="text-lg font-medium mb-4">Обзор</h3>
            </div>
        </template>

        <p class="text-lg  mb-4">Добро пожаловать в личный кабинет пациента, </p>
        <p class="text-lg  mb-4">здесь вы можете записаться на приём, настроить уведомления, а также получить обратную связь</p>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <DashboardCard
                        title="Ближайшие записи"
                        icon="ri-calendar-event-line"
                        :value="appointmentsCount"
                    />
                    <DashboardCard
                        title="Новые уведомления"
                        icon="ri-notification-line"
                        :value="unreadNotifications"
                    />
                    <DashboardCard
                        title="Медкарта"
                        icon="ri-file-text-line"
                        value="скоро"
                    />
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <h3 class="text-lg font-medium mb-4">Быстрый доступ</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <ActionButton
                            icon="ri-add-circle-line"
                            label="Новая запись"
                            variant="success"
                            @click=""
                        />
                        <ActionButton
                            icon="ri-file-edit-line"
                            label="Медкарта"
                            variant="success"
                            @click=""
                        />
                        <ActionButton
                            icon="ri-chat-smile-2-line"
                            label="Мои чаты"
                            variant="success"
                            @click=""
                        />
                        <ActionButton
                            icon="ri-settings-3-line"
                            label="Профиль"
                            variant="success"
                            @click=""
                        />
                    </div>
                </div>
            </div>
        </div>
    </ProfileLayout>
</template>

<script setup lang="ts">
import ProfileLayout from '../../layouts/ProfileLayout.vue';
import DashboardCard from '../../components/DashboardCard.vue';
import ActionButton from '../../components/ActionButton.vue';
import {Head} from "@inertiajs/vue3";

defineProps({
    appointmentsCount: Number,
    unreadNotifications: Number
});
</script>
