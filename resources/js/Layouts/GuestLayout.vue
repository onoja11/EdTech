<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center bg-gradient-to-br from-yellow-200 via-amber-50 to-orange-200 pt-6 sm:justify-center sm:pt-0"
    >
        <div>
            <Link href="/">
            <h1 class="text-4xl font-extrabold text-yellow-600 tracking-wide drop-shadow-sm">
            <span class="bg-gradient-to-r from-yellow-500 via-orange-500 to-amber-500 bg-clip-text text-transparent">
                edTech
            </span>
            </h1>
            </Link>
        </div>

        <div
            class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
