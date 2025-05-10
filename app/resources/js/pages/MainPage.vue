<template>
    <MainLayout> <HeroSection />
        <AboutSection />
        <ServicesSection :services="services" />
        <DoctorsSection />
        <AppointmentForm />
        <TestimonialsSection />
        <ContactSection />
        <NewsletterSection />
    </MainLayout>
</template>

<script setup lang="ts">
import { defineAsyncComponent } from 'vue';
import MainLayout from '../layouts/MainLayout.vue';
import {usePage} from "@inertiajs/vue3";

const { props } = usePage();
const services = props.services;

const HeroSection = defineAsyncComponent(() => import('../components/main/HeroSection.vue'));
const AboutSection = defineAsyncComponent(() => import('../components/main/AboutSection.vue'));
const ServicesSection = defineAsyncComponent(() => import('../components/main/ServiceSection.vue'));
const DoctorsSection = defineAsyncComponent(() => import('../components/main/DoctorsSection.vue'));
const AppointmentForm = defineAsyncComponent(() => import('../components/main/AppointmentForm.vue'));
const TestimonialsSection = defineAsyncComponent(() => import('../components/main/ReviewSection.vue'));
const ContactSection = defineAsyncComponent(() => import('../components/main/ContactSection.vue'));
const NewsletterSection = defineAsyncComponent(() => import('../components/main/NewsletterSection.vue'));


</script>
