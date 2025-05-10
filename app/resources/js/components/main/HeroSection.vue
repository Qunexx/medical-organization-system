<template>
    <section class="hero-section relative h-[600px]">
        <div class="absolute inset-0 hero-content flex items-center">
            <div class="container mx-auto px-4">
                <div class="max-w-xl">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Современная медицина для вашего здоровья</h1>
                    <p class="text-lg text-gray-700 mb-8">Мы предлагаем качественные медицинские услуги с использованием передовых технологий и индивидуальным подходом к каждому пациенту.</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#appointment" class="bg-primary text-white px-6 py-3 !rounded-button font-medium hover:bg-blue-600 transition text-center whitespace-nowrap">Записаться на прием</a>
                        <a href="#services" class="bg-white text-primary border border-primary px-6 py-3 !rounded-button font-medium hover:bg-gray-50 transition text-center whitespace-nowrap">Наши услуги</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">

</script>

<style scoped>
.hero-section {
    background-image: url(/storage/heroLayout.jpg);
    background-size: cover;
    background-position: center;
}

.hero-content {
    background: linear-gradient(90deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.9) 50%, rgba(255,255,255,0) 100%);
}
</style>
