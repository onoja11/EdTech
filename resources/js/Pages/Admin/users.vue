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
 
    <!-- Page Heading -->
    <div class="px-4 py-6 sm:px-6 lg:px-8 text-center">
      <h1 class="text-2xl font-bold mb-4">Manage Users</h1>
      <p class="text-gray-600">Here you can manage your users and their roles.</p>
    </div>

    <!-- Users Table -->
    <div class="p-4 overflow-x-auto  mx-4">
      <table class="min-w-full bg-white border shadow text-left">
        <thead>
          <tr>
            <th class="px-4 py-2 border">ID</th>
            <th class="px-4 py-2 border">Name</th>
            <th class="px-4 py-2 border">Email</th>
            <th class="px-4 py-2 border">Role</th>
            <th class="px-4 py-2 border">Department</th>
            <th class="px-4 py-2 border">Level</th>
            <th class="px-4 py-2 border text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id" class="hover:bg-gray-50">
            <td class="px-4 py-2 border">{{ user.id }}</td>
            <td class="px-4 py-2 border">{{ user.name }}</td>
            <td class="px-4 py-2 border">{{ user.email }}</td>
            <td class="px-4 py-2 border">{{ user.user_roles }}</td>
            <td class="px-4 py-2 border">{{ user.department }}</td>
            <td class="px-4 py-2 border">{{ user.level }}</td>
            <td class="px-4 py-2 border text-center">
              <Link
                class="text-blue-600 hover:text-blue-900"
                :href="`/user/${user.id}/edit`"
                >
                Edit
              </Link>
              <form @submit.prevent="router.delete(`/user/${user.id}/delete`)" class="inline">
                <button
                class="ml-2 text-red-600 hover:text-red-900"  >
                Delete
              </button>
              </form>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AuthenticatedLayout>
</template>
