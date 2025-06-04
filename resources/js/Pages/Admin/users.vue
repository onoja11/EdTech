<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineProps({
  users: Array,
});
</script>

<template>
  <Head title="Manage Users" />
  
  <AuthenticatedLayout>
    <div class="min-h-screen bg-gradient-to-br from-yellow-50 via-amber-50 to-orange-50">
      
      <!-- Header Section -->
      <div class="relative overflow-hidden">
        <div class="bg-gradient-to-r from-yellow-400 via-amber-400 to-orange-400 px-4 py-12 sm:px-6 lg:px-8">
          <!-- Decorative Background Pattern -->
          <div class="absolute inset-0 opacity-20">
            <svg width="100%" height="100%" viewBox="0 0 60 60" preserveAspectRatio="none">
              <defs>
                <pattern id="userPattern" width="20" height="20" patternUnits="userSpaceOnUse">
                  <circle cx="10" cy="10" r="2" fill="white" opacity="0.3"/>
                </pattern>
              </defs>
              <rect width="100%" height="100%" fill="url(#userPattern)" />
            </svg>
          </div>
          
          <div class="relative text-center max-w-4xl mx-auto">
            <!-- Users Management SVG -->
            <div class="flex justify-center mb-6">
              <svg width="80" height="80" viewBox="0 0 24 24" class="text-yellow-200">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2" fill="none"/>
                <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2" fill="none"/>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" stroke="currentColor" stroke-width="2" fill="none"/>
                <circle cx="18" cy="18" r="3" fill="currentColor"/>
                <path d="M16.5 18h3M18 16.5v3" stroke="white" stroke-width="1.5"/>
              </svg>
            </div>
            
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">User Management Hub</h1>
            <p class="text-xl text-yellow-100 max-w-2xl mx-auto">
              Manage your community of learners and teachers with ease.
            </p>
          </div>
        </div>
        
         
      </div>

      <!-- Stats Section -->
      <div class="px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
        <div class="max-w-7xl mx-auto">
          <div class="bg-white rounded-3xl shadow-2xl border-2 border-yellow-200 p-8 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              
              <!-- Total Users -->
              <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border-2 border-blue-200">
                <div class="flex items-center">
                  <div class="bg-gradient-to-r from-blue-400 to-indigo-500 p-3 rounded-xl mr-4">
                    <svg width="24" height="24" viewBox="0 0 24 24" class="text-white">
                      <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2" fill="none"/>
                      <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2" fill="none"/>
                      <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" stroke="currentColor" stroke-width="2" fill="none"/>
                    </svg>
                  </div>
                  <div>
                    <p class="text-3xl font-bold text-gray-800">{{ users?.length || 0 }}</p>
                    <p class="text-blue-600 font-semibold">Total Users</p>
                  </div>
                </div>
              </div>

              <!-- Admins Count -->
              <div class="bg-gradient-to-r from-amber-50 to-yellow-50 rounded-2xl p-6 border-2 border-amber-200">
                <div class="flex items-center">
                  <div class="bg-gradient-to-r from-amber-400 to-yellow-500 p-3 rounded-xl mr-4">
                    <svg width="24" height="24" viewBox="0 0 24 24" class="text-white">
                      <path d="M12 6L9 9l3-8 3 8z" fill="currentColor"/>
                      <path d="M12 6L9 9H3l2-7 4 4zM12 6l3 3h6l-2-7-4 4z" fill="currentColor"/>
                      <rect x="2" y="9" width="20" height="4" rx="2" fill="currentColor"/>
                    </svg>
                  </div>
                  <div>
                    <p class="text-3xl font-bold text-gray-800">{{ users?.filter(u => u.user_roles == 'admin').length  }}</p>
                    <p class="text-amber-600 font-semibold">Administrators</p>
                  </div>
                </div>
              </div>

              <!-- Students Count -->
              <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-6 border-2 border-green-200">
                <div class="flex items-center">
                  <div class="bg-gradient-to-r from-green-400 to-emerald-500 p-3 rounded-xl mr-4">
                    <svg width="24" height="24" viewBox="0 0 24 24" class="text-white">
                      <path d="M12 3L1 9l11 6 9-4.91V17h2v-8L12 3z" fill="currentColor"/>
                      <path d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z" fill="currentColor"/>
                    </svg>
                  </div>
                  <div>
                    <p class="text-3xl font-bold text-gray-800">{{ users?.filter(u => u.user_roles == 'student').length || 0 }}</p>
                    <p class="text-green-600 font-semibold">Students</p>
                  </div>
                </div>
              </div>

              <!-- Students Count -->
              <div class="bg-gradient-to-r from-red-50 to-sky-50-50 rounded-2xl p-6 border-2 border-red-200">
                <div class="flex items-center">
                  <div class="bg-gradient-to-r from-red-400 to-red-500 p-3 rounded-xl mr-4">
                    <svg width="24" height="24" viewBox="0 0 24 24" class="text-white">
                      <path d="M12 3L1 9l11 6 9-4.91V17h2v-8L12 3z" fill="currentColor"/>
                      <path d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z" fill="currentColor"/>
                    </svg>
                  </div>
                  <div>
                    <p class="text-3xl font-bold text-gray-800">{{ users?.filter(u => u.user_roles == 'teacher').length || 0 }}</p>
                    <p class="text-red-600 font-semibold">Teachers</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Users Table Section -->
      <div class="px-4 sm:px-6 lg:px-8 pb-16">
        <div class="max-w-7xl mx-auto">
          
          <!-- Section Header -->
          <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
              <svg width="48" height="48" viewBox="0 0 24 24" class="text-amber-600">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke="currentColor" stroke-width="2" fill="none"/>
                <line x1="16" y1="2" x2="16" y2="6" stroke="currentColor" stroke-width="2"/>
                <line x1="8" y1="2" x2="8" y2="6" stroke="currentColor" stroke-width="2"/>
                <line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="2"/>
              </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-4">User Directory</h2>
            <p class="text-lg text-gray-600">Manage roles, edit profiles, and maintain your learning community</p>
          </div>

          <!-- Users Table Card -->
          <div class="bg-white rounded-3xl shadow-2xl border-2 border-yellow-200 overflow-hidden">
            
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-amber-100 to-yellow-100 px-6 py-4 border-b-2 border-yellow-200">
              <h3 class="text-xl font-bold text-gray-800 flex items-center">
                <svg width="24" height="24" viewBox="0 0 24 24" class="text-amber-600 mr-2">
                  <path d="M9 12l2 2 4-4M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z" stroke="currentColor" stroke-width="2" fill="none"/>
                </svg>
                All Registered Users
              </h3>
            </div>

            <!-- Responsive Table -->
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-yellow-200">
                <thead class="bg-gradient-to-r from-yellow-50 to-amber-50">
                  <tr>
                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">
                      <div class="flex items-center">
                      
                        ID
                      </div>
                    </th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">
                      <div class="flex items-center">
                        Name
                      </div>
                    </th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">
                      <div class="flex items-center">
                        Email
                      </div>
                    </th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">
                      <div class="flex items-center">
                        Role
                      </div>
                    </th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">
                      <div class="flex items-center">
                        Department
                      </div>
                    </th>
                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-800 uppercase tracking-wider">
                      <div class="flex items-center">
                        Level
                      </div>
                    </th>
                    <th class="px-6 py-4 text-center text-sm font-bold text-gray-800 uppercase tracking-wider">
                      <div class="flex items-center justify-center">  
                        Actions
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-yellow-100">
                  <tr v-for="user in users" :key="user.id" class="hover:bg-gradient-to-r hover:from-yellow-50 hover:to-amber-50 transition-all duration-200">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                      <div class="flex items-center">
                        <div class="bg-gradient-to-r from-blue-100 to-indigo-100 p-2 rounded-lg mr-2">
                          <span class="text-blue-600 font-bold">#{{ user.id }}</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="bg-gradient-to-r from-green-400 to-emerald-500 p-2 rounded-full mr-3">
                          <svg width="20" height="20" viewBox="0 0 24 24" class="text-white">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2" fill="none"/>
                            <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" fill="none"/>
                          </svg>
                        </div>
                        <div>
                          <div class="text-sm font-bold text-gray-900">{{ user.name }}</div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <div class="flex items-center">
                        <svg width="16" height="16" viewBox="0 0 24 24" class="text-gray-400 mr-2">
                          <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" stroke="currentColor" stroke-width="2" fill="none"/>
                          <polyline points="22,6 12,13 2,6" stroke="currentColor" stroke-width="2" fill="none"/>
                        </svg>
                        {{ user.email }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center px-1 bg-gradient-to-r from-amber-100 to-yellow-100 text-amber-800 border border-amber-200" v-if="user.user_roles == 'admin'">
                        <svg width="16" height="16" viewBox="0 0 24 24" class="text-gray-400 mr-2">
                          <path d="M12 2L2 7v10l10 5 10-5V7L12 2z" stroke="currentColor" stroke-width="2" fill="none"/>
                          <line x1="12" y1="22" x2="12" y2="8" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        {{ user.user_roles || 'N/A' }}
                      </div>
                      <div class="flex items-center px-1 bg-gradient-to-r from-red-100 to-red-100 text-red-800 border border-red-200" v-if="user.user_roles == 'teacher'">
                        <svg width="16" height="16" viewBox="0 0 24 24" class="text-gray-400 mr-2">
                          <path d="M12 2L2 7v10l10 5 10-5V7L12 2z" stroke="currentColor" stroke-width="2" fill="none"/>
                          <line x1="12" y1="22" x2="12" y2="8" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        {{ user.user_roles || 'N/A' }}
                      </div>
                      
                      <div class="flex items-center px-1 bg-gradient-to-r from-green-100 to-green-100 text-green-800 border border-green-200" v-if="user.user_roles == 'student'">
                        <svg width="16" height="16" viewBox="0 0 24 24" class="text-gray-400 mr-2">
                          <path d="M12 2L2 7v10l10 5 10-5V7L12 2z" stroke="currentColor" stroke-width="2" fill="none"/>
                          <line x1="12" y1="22" x2="12" y2="8" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        {{ user.user_roles || 'N/A' }}
                      </div>
                      
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <div class="flex items-center">
                        <svg width="16" height="16" viewBox="0 0 24 24" class="text-gray-400 mr-2">
                          <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16" stroke="currentColor" stroke-width="2" fill="none"/>
                        </svg>
                        {{ user.department || 'N/A' }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      <div class="flex items-center">
                        <svg width="16" height="16" viewBox="0 0 24 24" class="text-gray-400 mr-2">
                          <polyline points="22,12 18,12 15,21 9,3 6,12 2,12" stroke="currentColor" stroke-width="2" fill="none"/>
                        </svg>
                        {{ user.level || 'N/A' }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                      <div class="flex items-center justify-center space-x-3">
                        <!-- Edit Button -->
                        <Link
                          :href="`/user/${user.id}/edit`"
                          class="group bg-gradient-to-r from-blue-400 to-indigo-500 hover:from-blue-500 hover:to-indigo-600 text-white p-2 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg"
                          title="Edit User"
                        >
                          <svg width="16" height="16" viewBox="0 0 24 24" class="group-hover:scale-110 transition-transform">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" stroke="currentColor" stroke-width="2" fill="none"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" fill="none"/>
                          </svg>
                        </Link>
                        
                        <!-- Delete Button -->
                        <form @submit.prevent="router.delete(`/user/${user.id}/delete`)" class="inline">
                          <button
                            type="submit"
                            class="group bg-gradient-to-r from-red-400 to-pink-500 hover:from-red-500 hover:to-pink-600 text-white p-2 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg"
                            title="Delete User"
                            @click="confirm('Are you sure you want to delete this user?') || $event.preventDefault()"
                          >
                            <svg width="16" height="16" viewBox="0 0 24 24" class="group-hover:scale-110 transition-transform">
                              <polyline points="3,6 5,6 21,6" stroke="currentColor" stroke-width="2" fill="none"/>
                              <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" stroke="currentColor" stroke-width="2" fill="none"/>
                              <line x1="10" y1="11" x2="10" y2="17" stroke="currentColor" stroke-width="2"/>
                              <line x1="14" y1="11" x2="14" y2="17" stroke="currentColor" stroke-width="2"/>
                            </svg>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

     
      
    </div>
  </AuthenticatedLayout>
</template>