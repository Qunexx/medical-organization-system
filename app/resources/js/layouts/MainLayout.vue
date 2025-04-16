<template>
    <div class="bg-white-100">
        <Header />
        <main>
            <slot /> </main>
        <Footer />
    </div>
</template>

<script setup lang="ts">
import Header from '../components/Header.vue';
import Footer from '../components/Footer.vue';

</script>

<style>
</style>
