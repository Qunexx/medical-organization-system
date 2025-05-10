<template>
    <nav v-if="links.length > 3" class="flex items-center justify-between">
        <div class="flex-1 flex items-center gap-1">
            <!-- Previous Button -->
            <button
                v-if="links[0].url"
                @click="visit(links[0].url)"
                :disabled="!links[0].url"
                class="px-3 py-1 border rounded text-gray-700 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
            >
                &laquo; Назад
            </button>

            <!-- Page Numbers -->
            <template v-for="(link, index) in links.slice(1, -1)">
        <span
            v-if="link.label.includes('...')"
            :key="'dots-' + index"
            class="px-3 py-1 text-gray-500"
        >
          ...
        </span>
                <button
                    v-else
                    :key="index"
                    @click="visit(link.url)"
                    class="px-3 py-1 border rounded text-gray-700 hover:bg-gray-100 transition-colors"
                    :class="{ 'bg-blue-600 text-white border-blue-600': link.active }"
                >
                    {{ link.label }}
                </button>
            </template>

            <!-- Next Button -->
            <button
                v-if="links[links.length - 1].url"
                @click="visit(links[links.length - 1].url)"
                :disabled="!links[links.length - 1].url"
                class="px-3 py-1 border rounded text-gray-700 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
            >
                Вперед &raquo;
            </button>
        </div>
    </nav>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3'

defineProps({
    links: {
        type: Array as () => Array<{
            url: string | null
            label: string
            active: boolean
        }>,
        required: true
    }
})

const visit = (url: string | null) => {
    if (url) {
        router.visit(url)
    }
}
</script>
