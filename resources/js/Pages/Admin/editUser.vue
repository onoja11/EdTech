<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import SecondaryButton from '@/Components/PrimaryButton.vue'
import InputLabel from '@/Components/InputLabel.vue'
import Input from '@/Components/TextInput.vue'

const props= defineProps({
  user: Object,
});

const form = useForm({
name: props.user.name,
email: props.user.email,
user_roles: props.user.user_roles,
department: props.user.department,
level: props.user.level

})


const submit = () => {
    form.put(route('users.update', props.user.id));
}
</script>

<template>
  <Head title="Edit" />

  <AuthenticatedLayout>
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-amber-50 to-orange-50">
      <div class="max-w-2xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Page Heading -->
    <div class="px-4 py-6 sm:px-6 lg:px-8 text-center">
      <h1 class="text-4xl text-gray-500 font-bold mb-4  capitalize">Edit "{{ user.name + '\'s' }}" Information</h1>
        <p class="text-gray-600">Update the details below to modify user information.</p>
      </div>

 <div class="bg-white rounded-3xl shadow-2xl p-8 mb-8 border border-yellow-200">
      <form @submit.prevent="submit">
        <div class="mb-3">
          <!-- <label class="block mb-1 font-medium">Title</label> -->
          <InputLabel >Name</InputLabel>
          <Input type="text" class="w-full p-2 border-2 border-yellow-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-yellow-200 focus:border-amber-400 text-gray-800 placeholder-gray-500 text-lg " v-model="form.name"/>
          <div v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</div>
        </div>
        
        <div class="mb-3">
          <!-- <label class="block mb-1 font-medium">Title</label> -->
          <InputLabel >Email</InputLabel>
          <Input type="text" class="w-full p-2 border-2 border-yellow-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-yellow-200 focus:border-amber-400 text-gray-800 placeholder-gray-500 text-lg" v-model="form.email"/>
          <div v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</div>
        </div>
        
        <div class="mb-3">
          <!-- <label class="block mb-1 font-medium">Title</label> -->
          <InputLabel >Role</InputLabel>
          <Input type="text" class="w-full p-2 border-2 border-yellow-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-yellow-200 focus:border-amber-400 text-gray-800 placeholder-gray-500 text-lg" v-model="form.user_roles"/>
          <div v-if="form.errors.user_roles" class="text-red-500 text-sm">{{ form.errors.user_roles }}</div>
        </div>
        
        <div class="mb-3">
          <!-- <label class="block mb-1 font-medium">Title</label> -->
          <InputLabel >Level</InputLabel>
          <Input type="text" class="w-full p-2 border-2 border-yellow-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-yellow-200 focus:border-amber-400 text-gray-800 placeholder-gray-500 text-lg" v-model="form.level"/>
          <div v-if="form.errors.level" class="text-red-500 text-sm">{{ form.errors.level }}</div>
        </div>

        <div class="mb-3">
          <!-- <label class="block mb-1 font-medium">Title</label> -->
          <InputLabel >Department</InputLabel>
          <Input type="text" class="w-full p-2 border-2 border-yellow-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-yellow-200 focus:border-amber-400 text-gray-800 placeholder-gray-500 text-lg" v-model="form.department"/>
          <div v-if="form.errors.department" class="text-red-500 text-sm">{{ form.errors.department }}</div>
        </div>
        <SecondaryButton type="submit" class="mt-4 w-full flex justify-center bg-gradient-to-r from-amber-400 to-yellow-500 hover:from-amber-500 hover:to-yellow-600 disabled:from-gray-300 disabled:to-gray-400 text-white px-8 py-3 rounded-xl transition-all duration-300 transform hover:scale-105 font-semibold text-lg shadow-lg">Update</SecondaryButton>
      </form>
    </div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>
