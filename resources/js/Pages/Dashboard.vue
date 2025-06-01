<script setup>
import { Head, Link} from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'




defineProps({
  lessons: Array,
  user_role: String
});
</script>

<template>
  <Head title="Dashboard" />
 
  <AuthenticatedLayout>
   
    <!-- Flash Toast Message -->



    <!-- Welcome Message -->
    <div class="px-4 py-6 sm:px-6 lg:px-8 text-center">
      <h1 class="text-2xl font-bold mb-4">Welcome to <span v-if="user_role === 'admin'" class="font-extrabold">Your ADMIN</span> Dashboard </h1>
      <p class="text-gray-600">Here you can manage your lessons and resources.</p>
    </div>

    <!-- Create Lesson Button for Admins -->
       <div v-if="user_role === 'admin'" class="flex gap-2 px-4 mt-6">
         <Link
           :href="route('lessons.create')"
           class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
         >
           Create Lesson
         </Link>
         <Link
           :href="route('users.all')"
           class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
         >
           View User
         </Link>
       </div>

    <!-- Lessons Grid -->
    <div class="mt-10 px-4 max-w-7xl mx-auto">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="lesson in lessons"
          :key="lesson.id"
          class="bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 cursor-pointer h-64 w-full"
        >
          <a :href="`/lessons/${lesson.id}`" class="block h-full p-6">
            <div class="flex flex-col justify-center items-center h-full">
              <div class="bg-white text-blue-500 p-3 rounded-full mb-4">
                <i class="fa-solid fa-book fa-2x"></i>
              </div>
              <h2 class="text-xl font-semibold text-center">{{ lesson.title }}</h2>
              <!-- <p class="mt-2 text-sm text-blue-200 text-center">
                {{ lesson.content }}
              </p> -->
            </div>
          </a>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
