<template>
<Head title="Смена пароля" />
<ProfileLayout>
<template #header>
    <h3 class="text-lg font-medium mb-4">Смена пароля</h3>
</template>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <UpdatePasswordForm class="max-w-xl" />
        </div>
    </div>
</div>
</ProfileLayout>
</template>
<script setup lang="ts">
import ProfileLayout from '../../layouts/ProfileLayout.vue';
import UpdatePasswordForm from '../../components/profile/UpdatePasswordForm.vue';
import {Head} from "@inertiajs/vue3";

defineProps({
    user: Object,
    status: String,
    settings: Object
});
</script>
