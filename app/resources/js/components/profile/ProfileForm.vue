<template>
    <form @submit.prevent="submit" class="space-y-6">
        <div>
            <label class="block font-medium text-sm text-gray-700 mb-2">Дата рождения</label>
            <input
                type="date"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm"
                v-model="form.birthday"
                :max="new Date().toISOString().split('T')[0]"
            />
        </div>

        <div>
            <label class="block font-medium text-sm text-gray-700 mb-2 flex justify-between items-center">
                Telegram ID
                <Link :href="route('patient.notification')" class="ml-4 whitespace-nowrap">Настроить уведомления →</Link>
            </label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">@</span>
                <input
                    type="text"
                    class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm"
                    v-model="form.telegram_account"
                    placeholder="username"
                />
            </div>
        </div>

        <div v-if="Object.keys(form.errors).length" class="bg-red-50 text-red-600 p-4 rounded-lg">
            <div v-for="error in form.errors" :key="error" class="text-sm">
                {{ error }}
            </div>
        </div>

        <div class="flex items-center gap-4">
            <button
                type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 transition-all duration-200 shadow-sm"
                :disabled="form.processing"
            >
                <span v-if="!form.processing">Сохранить изменения</span>
                <span v-else class="flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Сохранение...
                </span>
            </button>

            <transition name="fade">
                <div v-if="showSuccessMessage" class="text-green-600 text-sm font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Данные успешно обновлены!
                </div>
            </transition>
        </div>
    </form>
</template>

<script setup lang="ts">
import {Link, useForm} from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const showSuccessMessage = ref(false);

const form = useForm({
    birthday: formatDate(page.props.auth.user.birthday),
    telegram_account: page.props.auth.user.telegram_account || ''
});

function formatDate(dateString?: string) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toISOString().split('T')[0];
}

const submit = () => {
    form.post(route('patient.profile.additional.update'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            showSuccessMessage.value = true;
            setTimeout(() => {
                showSuccessMessage.value = false;
            }, 3000);
        }
    });
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.animate-spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.loading {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.spinner {
    width: 1rem;
    height: 1rem;
    border: 2px solid rgba(255,255,255,0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.error-message {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

.success-message {
    color: #28a745;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
</style>
