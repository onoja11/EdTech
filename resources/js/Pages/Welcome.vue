<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: { type: String, required: true },
    phpVersion: { type: String, required: true },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />

    <div class="min-h-screen bg-gradient-to-r from-yellow-500 via-orange-500 to-amber-500 flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <section
            class="w-full max-w-4xl shadow-lg mx-auto text-center bg-white p-6 sm:p-8 lg:p-12 rounded-xl border border-white border-opacity-20 space-y-4 sm:space-y-6"
        >
            <!-- Title -->
            <h2 class="text-yellow-800 text-xl sm:text-3xl md:text-4xl font-semibold font-serif">
                Welcome To
            </h2>

            <!-- Logo -->
            <ApplicationLogo class="w-16 sm:w-20 md:w-24 h-auto inline" />

            <!-- Description -->
            <p class="text-gray-600 text-sm sm:text-base md:text-lg">
                A platform for students to learn and grow.
            </p>

            <!-- Buttons -->
            <div
                class="flex flex-col sm:flex-row justify-center p-4 gap-4 sm:gap-6 md:gap-8"
            >
                <!-- Login Button -->
                <a
                    :href="route('login')"
                    class="bg-gradient-to-r from-amber-400 to-yellow-500 hover:from-amber-500 hover:to-yellow-600 
                           text-white px-6 py-3 md:px-12 md:py-3 
                           rounded-xl transition-all duration-300 transform hover:scale-105 
                           font-semibold text-base md:text-lg shadow-lg text-center"
                >
                    <i class="fas fa-graduation-cap mr-2"></i> Login
                </a>

                <!-- Register Button -->
                <a
                    :href="route('register')"
                    class="bg-gradient-to-r from-amber-600 to-yellow-500 hover:from-amber-600 hover:to-yellow-600
                           text-white px-9 py-3 md:px-12 md:py-3 
                           rounded-xl transition-all duration-300 transform hover:scale-105
                           font-semibold text-base md:text-lg shadow-lg text-center"
                >
                    <i class="fas fa-user-shield mr-2"></i> Register
                </a>
            </div>
        </section>
    </div>
</template>
