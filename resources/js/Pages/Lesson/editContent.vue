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
const props = defineProps({
  lesson: Object,
})
const change = (event) => {
  form.content = event.target.files[0]
}

const submit = () => {
  form.post(route('lessons.update.content', props.lesson.id),{
        forceFormData: true,
  })
}
</script>

<template>
  <Head title="Create Lesson" />

  <AuthenticatedLayout>
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-amber-50 to-orange-50">
      <div class="max-w-2xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Page Heading -->
      <div class="px-4 py-6 sm:px-6 lg:px-8 text-center">
      <h1 class="text-5xl text-gray-500 font-bold mb-4">Edit "{{ lesson.title }}" Content</h1>
      <p class="text-gray-600">
Edit the content below to update the lesson material. You can upload a new file or replace the existing one. Make sure the file is in a supported format.</p>
      </div>

 <div class="bg-white rounded-3xl shadow-2xl p-8 mb-8 border border-yellow-200">
      <form @submit.prevent="submit" >
        <div class="mb-2"> 
          <label class="block mb-1 font-medium">Content</label>
          <input type="file" id="content" @input="change" class="w-full p-2 border-2 border-yellow-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-yellow-200 focus:border-amber-400 text-gray-800 placeholder-gray-500 text-lg"/>
          <div v-if="form.errors.content" class="text-red-500 text-sm">{{ form.errors.content }}</div>
        </div>

        
        <SecondaryButton type="submit" class="mt-4 w-full flex justify-center bg-gradient-to-r from-amber-400 to-yellow-500 hover:from-amber-500 hover:to-yellow-600 disabled:from-gray-300 disabled:to-gray-400 text-white px-8 py-3 rounded-xl transition-all duration-300 transform hover:scale-105 font-semibold text-lg shadow-lg">Create</SecondaryButton>
      </form>
      </div>
  

      </div>
    </div>
   
  </AuthenticatedLayout>
</template>
