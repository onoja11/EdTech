<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
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
     <div class="min-h-screen bg-gradient-to-r from-yellow-500 via-orange-500 to-amber-500 flex items-center justify-center">

                <section class="w-full max-w-4xl shadow-lg mx-auto text-center bg-white  p-8 rounded-lg border border-white border-opacity-20">
                    <h2 class="text-yellow-800 text-2xl sm:text-3xl md:text-4xl   font-semibold font-serif ">Welcome To</h2>
                    
                    <ApplicationLogo class="w-20 h-25  inline " />

                    <p class="text-gray-600 text-md">
                        A platform for students to learn and grow.
                    </p>
                    
                    <div class="flex flex-row sm:flex-row justify-center p-5 gap-4 sm:gap-6 md:gap-8 pt-3">
                        <a :href="route('login')" class="ms-4  bg-gradient-to-r from-amber-400 to-yellow-500 hover:from-amber-500 hover:to-yellow-600 disabled:from-gray-300 disabled:to-gray-400 text-white px-24 py-3 rounded-xl transition-all duration-300 transform hover:scale-105 font-semibold text-lg shadow-lg">
                            <i class="fas fa-graduation-cap text-white"></i> Login
                        </a>
                        <a :href="route('register')" class="ms-4 bg-gradient-to-r from-amber-600 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 disabled:from-gray-300 disabled:to-gray-400 text-white px-24 py-3 rounded-xl transition-all duration-300 transform hover:scale-105 font-semibold text-lg shadow-lg">
                            <i class="fas fa-user-shield"></i> Register
                        </a>
                    </div>
                </section>
            
        </div>
</template>
