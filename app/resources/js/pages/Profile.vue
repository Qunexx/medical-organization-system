<template>
    <Head title="Профиль" />

    <ProfileLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Профиль пользователя</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdateProfileForm
                        :user="user"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

            </div>
        </div>
    </ProfileLayout>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import UpdateProfileForm from '../components/profile/UpdateProfileForm.vue';
import ProfileLayout from "@/layouts/ProfileLayout.vue";

interface User {
    id: number;
    name: string;
    email: string;
    phone?: string | null;
}

</script>
