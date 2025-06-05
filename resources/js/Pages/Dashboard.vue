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
    <div class="min-h-screen bg-gradient-to-br from-yellow-50 via-amber-50 to-orange-50">
      
      <!-- Hero Section with Welcome Message -->
      <div class="relative overflow-hidden">
        <div class="bg-gradient-to-r from-yellow-400 via-amber-400 to-orange-400 px-4 py-12 sm:px-6 lg:px-8">
          
          
          <div class="relative text-center max-w-4xl mx-auto">
            <!-- Crown SVG for Admin -->
            <div v-if="user_role === 'admin'" class="flex justify-center mb-4">
              <svg width="60" height="60" viewBox="0 0 24 24" class="text-yellow-200">
                <path d="M12 6L9 9l3-8 3 8z" fill="currentColor"/>
                <path d="M12 6L9 9H3l2-7 4 4zM12 6l3 3h6l-2-7-4 4z" fill="currentColor"/>
                <rect x="2" y="9" width="20" height="4" rx="2" fill="currentColor"/>
                <path d="M4 13v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-6" stroke="currentColor" stroke-width="2" fill="none"/>
              </svg>
            </div>
            
            <!-- Student Cap SVG for regular users -->
            <div v-else class="flex justify-center mb-4">
              <svg width="60" height="60" viewBox="0 0 24 24" class="text-yellow-200">
                <path d="M12 3L1 9l11 6 9-4.91V17h2v-8L12 3z" fill="currentColor"/>
                <path d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z" fill="currentColor"/>
              </svg>
            </div>
            
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
              Welcome to 
              <span v-if="user_role === 'admin'" class="block text-yellow-100 mt-2">
                Your ADMIN Dashboard
              </span>
              <span v-else class="block text-yellow-100 mt-2">
                Your Learning Hub
              </span>
            </h1>
            <p class="text-xl text-yellow-100 max-w-2xl mx-auto">
              <span v-if="user_role === 'admin'">
                Manage lessons, track student progress, and create amazing learning experiences.
              </span>
              <span v-else>
                Explore your lessons, dive into new topics, and enhance your knowledge journey.
              </span>
            </p>
          </div>
        </div>
        
       
      </div>

      <!-- Admin Action Buttons -->
      <div  class="px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
        <div class="max-w-7xl mx-auto">
          <div class="flex flex-wrap gap-4 justify-center">
            <Link  v-if="user_role === 'teacher' || user_role === 'admin' "
              :href="route('lessons.create')"
              class="group bg-white hover:bg-yellow-50 border-2 border-yellow-300 hover:border-amber-400 rounded-2xl px-8 py-4 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl"
            >
              <div class="flex items-center space-x-3">
                <!-- Plus/Create SVG -->
                <div class="bg-gradient-to-r from-amber-400 to-yellow-500 p-2 rounded-xl">
                  <svg width="24" height="24" viewBox="0 0 24 24" class="text-white">
                    <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                  </svg>
                </div>
                <span class="font-bold text-gray-800 text-lg">Create New Lesson</span>
              </div>
            </Link>
            
            <Link v-if="user_role === 'admin' "
              :href="route('users.all')"
              class="group bg-white hover:bg-yellow-50 border-2 border-yellow-300 hover:border-amber-400 rounded-2xl px-8 py-4 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl"
            >
              <div class="flex items-center space-x-3">
                <!-- Users SVG -->
                <div class="bg-gradient-to-r from-amber-400 to-yellow-500 p-2 rounded-xl">
                  <svg width="24" height="24" viewBox="0 0 24 24" class="text-white">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2" fill="none"/>
                    <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" stroke="currentColor" stroke-width="2" fill="none"/>
                  </svg>
                </div>
                <span class="font-bold text-gray-800 text-lg">Manage Users</span>
              </div>
            </Link>
          </div>
        </div>
      </div>

      <!-- Lessons Section -->
      <div class="mt-16 px-4 sm:px-6 lg:px-8 pb-16">
        <div class="max-w-7xl mx-auto">
          
          <!-- Section Header -->
          <div class="text-center mb-12">
            <div class="flex justify-center mb-4">
              <!-- Library/Books SVG -->
              <svg width="48" height="48" viewBox="0 0 24 24" class="text-amber-600">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" stroke="currentColor" stroke-width="2" fill="none"/>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" stroke="currentColor" stroke-width="2" fill="none"/>
                <path d="M8 7h8M8 11h6" stroke="currentColor" stroke-width="2"/>
              </svg>
            </div>
            <h2 class="text-4xl font-bold text-gray-800 mb-4">
              <span v-if="user_role === 'teacher'">Your Created Lessons</span>
              <span v-else-if="user_role === 'admin'">Created Lessons</span>
              <span v-else>Available Lessons</span>
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
              <span v-if="user_role === 'teacher'">
                Review and manage the lessons you've created for your students.
              </span>
              <span v-else-if="user_role === 'admin'">
                Review and manage the lessons.
              </span>
              <span v-else>
                Discover engaging lessons crafted just for you. Click on any lesson to start learning!
              </span>
            </p>
          </div>

          <!-- Lessons Grid -->
          <div v-if="lessons && lessons.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <div
              v-for="lesson in lessons"
              :key="lesson.id"
              class="group relative"
            >
              <Link :href="`/lessons/${lesson.id}`" class="block">
                <div class="bg-white hover:bg-gradient-to-br hover:from-yellow-50 hover:to-amber-50 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 border-2 border-yellow-200 hover:border-amber-300 overflow-hidden h-72">
                  
                  <!-- Card Header with Subject Badge -->
                  <div class="bg-gradient-to-r from-amber-100 to-yellow-100 p-4 border-b border-yellow-200">
                    <div class="inline-block bg-gradient-to-r from-amber-400 to-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                      {{ lesson.subject }}
                    </div>
                  </div>
                  
                  <!-- Card Content -->
                  <div class="p-6 flex flex-col justify-center items-center h-48">
                    
                    <!-- Book Icon -->
                    <div class="bg-gradient-to-r from-amber-400 to-yellow-500 p-4 rounded-2xl mb-4 group-hover:scale-110 transition-transform duration-300">
                      <svg width="32" height="32" viewBox="0 0 24 24" class="text-white">
                        <path d="M4 2h16a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z" stroke="currentColor" stroke-width="2" fill="none"/>
                        <path d="M8 6h8M8 10h8M8 14h5" stroke="currentColor" stroke-width="2"/>
                      </svg>
                    </div>
                    
                    <!-- Lesson Title -->
                    <h3 class="text-xl font-bold text-gray-800 text-center mb-2 line-clamp-2 group-hover:text-amber-700 transition-colors">
                      {{ lesson.title }}
                    </h3>
                    
                    <!-- Start Learning Indicator -->
                    <div class="flex items-center text-amber-600 font-medium group-hover:text-amber-700">
                      <span class="mr-2">Start Learning</span>
                      <!-- Arrow SVG -->
                      <svg width="16" height="16" viewBox="0 0 24 24" class="transform group-hover:translate-x-1 transition-transform">
                        <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </div>
                  </div>
                  
                  <!-- Hover Overlay -->
                  <div class="absolute inset-0 bg-gradient-to-r from-amber-400/0 to-yellow-500/0 group-hover:from-amber-400/10 group-hover:to-yellow-500/10 transition-all duration-300 rounded-3xl"></div>
                </div>
              </Link>
            </div>
          </div>
          
          <!-- Empty State -->
          <div v-else class="text-center py-16 bg-white shadow">
            <div class="flex justify-center mb-6">
              <!-- Empty State SVG -->
              <svg width="80" height="80" viewBox="0 0 24 24" class="text-gray-400">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1" fill="none"/>
                <path d="M8 12h8M12 8v8" stroke="currentColor" stroke-width="1"/>
              </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-600 mb-4">No Lessons Available</h3>
            <p class="text-gray-500 text-lg mb-8">
              <span v-if="user_role === 'admin' || user_role === 'teacher'">
                Start creating your first lesson to help students learn!
              </span>
              <span v-else>
                Check back soon for new lessons to explore.
              </span>
            </p>
            
            <Link v-if="user_role === 'admin' || user_role === 'teacher'" 
                  :href="route('lessons.create')"
                  class="inline-flex items-center bg-gradient-to-r from-amber-400 to-yellow-500 hover:from-amber-500 hover:to-yellow-600 text-white px-8 py-3 rounded-xl font-semibold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
              <svg width="20" height="20" viewBox="0 0 24 24" class="mr-2">
                <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              </svg>
              Create Your First Lesson
            </Link>
          </div>
        </div>
      </div>

     
    </div>
  </AuthenticatedLayout>
</template>