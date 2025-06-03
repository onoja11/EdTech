<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import SecondaryButton from '@/Components/PrimaryButton.vue'
import InputLabel from '@/Components/InputLabel.vue'
import Input from '@/Components/TextInput.vue'
const form = useForm({
  title: '',
  content: null,
  subject:'',
  grade_level:'',
})
const change = (event) => {
  form.content = event.target.files[0]
}

const submit = () => {
  form.post('/lessons',{
        forceFormData: true,
  })
}
</script>

<template>
  <Head title="Create Lesson" />

  <AuthenticatedLayout>
    <!-- Page Heading -->
    <div class="px-4 py-6 sm:px-6 lg:px-8 text-center">
      <h1 class="text-2xl font-bold mb-4">Create a New Lesson</h1>
      <p class="text-gray-600">Fill in the details below to create a new lesson.</p>
      </div>

    <div class="p-4 max-w-xl mx-auto">
      <form @submit.prevent="submit" class="space-y-4 bg-white p-6 rounded shadow">
        <div class="mb-2">
          <!-- <label class="block mb-1 font-medium">Title</label> -->
          <InputLabel >Title</InputLabel>
          <Input type="text" class="w-full" v-model="form.title"/>
          <div v-if="form.errors.title" class="text-red-500 text-sm">{{ form.errors.title }}</div>
        </div>
        
        <div class="mb-2">
          <!-- <label class="block mb-1 font-medium">Title</label> -->
          <InputLabel >Subject</InputLabel>
          <Input type="text" class="w-full" v-model="form.subject"/>
          <div v-if="form.errors.subject" class="text-red-500 text-sm">{{ form.errors.subject }}</div>
        </div>
        
        <div class="mb-2">
          <!-- <label class="block mb-1 font-medium">Title</label> -->
          <InputLabel >Level</InputLabel>
          <Input type="text" class="w-full" v-model="form.grade_level"/>
          <div v-if="form.errors.grade_level" class="text-red-500 text-sm">{{ form.errors.grade_level }}</div>
        </div>

        <div class="mb-2"> 
          <label class="block mb-1 font-medium">Content</label>
          <input type="file" id="content" @input="change" class="w-full border px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500 rounded"/>
          <div v-if="form.errors.content" class="text-red-500 text-sm">{{ form.errors.content }}</div>
        </div>

        
        <SecondaryButton type="submit" >Create</SecondaryButton>
      </form>
    </div>
  </AuthenticatedLayout>
</template>
