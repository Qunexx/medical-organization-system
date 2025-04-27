<template>
    <form @submit.prevent="submit" class="space-y-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Текущий пароль
                <span class="text-red-500">*</span>
            </label>
            <input
                type="password"
                v-model="form.current_password"
                required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            />
            <div v-if="form.errors.current_password" class="text-red-500 text-sm mt-1">
                {{ form.errors.current_password }}
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Новый пароль
                <span class="text-red-500">*</span>
            </label>
            <input
                type="password"
                v-model="form.password"
                required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            />
            <div v-if="form.errors.password" class="text-red-500 text-sm mt-1">
                {{ form.errors.password }}
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Подтвердите пароль
                <span class="text-red-500">*</span>
            </label>
            <input
                type="password"
                v-model="form.password_confirmation"
                required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            />
        </div>

        <div class="flex items-center gap-4">
            <button
                type="submit"
                :disabled="form.processing"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50"
            >
                Сменить пароль
            </button>

            <transition
                enter-active-class="transition-opacity duration-200"
                leave-active-class="transition-opacity duration-200"
                enter-from-class="opacity-0"
                leave-to-class="opacity-0"
            >
                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
                    Пароль успешно изменен!
                </p>
            </transition>
        </div>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
})

const submit = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation')
            }
        }
    })
}
</script>
