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
    <!-- Page Heading -->
    <div class="px-4 py-6 sm:px-6 lg:px-8 text-center">
      <h1 class="text-2xl font-bold mb-4 capitalize">Edit "{{ user.name + '\'s' }}" Information</h1>
        <p class="text-gray-600">Update the details below to modify user information.</p>
      </div>

    <div class="p-4 max-w-xl mx-auto">
      <form @submit.prevent="submit" class="space-y-4 bg-white p-6 rounded shadow">
        <div class="mb-2">
          <!-- <label class="block mb-1 font-medium">Title</label> -->
          <InputLabel >Name</InputLabel>
          <Input type="text" class="w-full" v-model="form.name"/>
          <div v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</div>
        </div>
        
        <div class="mb-2">
          <!-- <label class="block mb-1 font-medium">Title</label> -->
          <InputLabel >Email</InputLabel>
          <Input type="text" class="w-full" v-model="form.email"/>
          <div v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</div>
        </div>
        
        <div class="mb-2">
          <!-- <label class="block mb-1 font-medium">Title</label> -->
          <InputLabel >Role</InputLabel>
          <Input type="text" class="w-full" v-model="form.user_roles"/>
          <div v-if="form.errors.user_roles" class="text-red-500 text-sm">{{ form.errors.user_roles }}</div>
        </div>
        
        <div class="mb-2">
          <!-- <label class="block mb-1 font-medium">Title</label> -->
          <InputLabel >Level</InputLabel>
          <Input type="text" class="w-full" v-model="form.level"/>
          <div v-if="form.errors.level" class="text-red-500 text-sm">{{ form.errors.level }}</div>
        </div>

        <div class="mb-2">
          <!-- <label class="block mb-1 font-medium">Title</label> -->
          <InputLabel >Department</InputLabel>
          <Input type="text" class="w-full" v-model="form.department"/>
          <div v-if="form.errors.department" class="text-red-500 text-sm">{{ form.errors.department }}</div>
        </div>
        <SecondaryButton type="submit" >Update</SecondaryButton>
      </form>
    </div>
  </AuthenticatedLayout>
</template>
