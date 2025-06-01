<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
  lessons: Array
});
</script>

<template>
    <Head title="Lessons" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Lessons
            </h2>
        </template>

        <div class="p-4">
            <h1 class="text-2xl font-bold mb-4">All Lessons</h1>

            <table class="min-w-full bg-white border">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Title</th>
                        <th class="px-4 py-2 border">Description</th>
                        <!-- Add more columns if needed -->
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="lesson in lessons" :key="lesson.id">
                        <td class="px-4 py-2 border">{{ lesson.id }}</td>
                        <td class="px-4 py-2 border">{{ lesson.title }}</td>
                        <td class="px-4 py-2 border">{{ lesson.content }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>
