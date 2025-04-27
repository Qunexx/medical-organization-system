<!-- resources/js/Pages/Profile/Edit.vue -->
<template>
    <Head title="Профиль" />
    <ProfileLayout>
        <template #header>
            <h3 class="text-lg font-medium mb-4">Профиль</h3>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <AvatarUploader :user="user" />
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdateProfileForm
                        :user="user"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <ExtendedProfileForm
                        :user="user"
                        class="max-w-xl"
                    />
                </div>
            </div>
        </div>
    </ProfileLayout>
</template>

<script setup lang="ts">
import ProfileLayout from '../../layouts/ProfileLayout.vue';
import UpdateProfileForm from '../../components/profile/UpdateProfileForm.vue';
import ExtendedProfileForm from '../../components/profile/ProfileForm.vue';
import AvatarUploader from '../../components/profile/AvatarUploader.vue';
import {Head} from "@inertiajs/vue3";

defineProps({
    user: Object,
    status: String,
    settings: Object
});
</script>
