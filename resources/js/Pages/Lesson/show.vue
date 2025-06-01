<script setup>
import { ref } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import Input from "@/Components/TextInput.vue";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineProps({
  lesson: Object,
  created_by: Object,
})

// Reactive states
const questionInput = ref('')
const questions = ref([])

// Handle submission
const submitQuestion = () => {
  if (questionInput.value.trim()) {
    questions.value.push({
      id: Date.now(),
      content: questionInput.value.trim()
    })
    questionInput.value = ''
  }
}
</script>

<template>
  <Head :title="lesson.title" />

  <AuthenticatedLayout>
    <!-- Lesson Title and Author -->
    <div class="px-4 py-6 sm:px-6 lg:px-8 text-center">
      <h1 class="text-2xl font-bold mb-4">{{ lesson.title }}</h1>
      <p class="text-gray-600 mb-4">Lecturer: {{ created_by.name }}</p>
    </div>

    <!-- Lesson Content -->
    <div class="px-4 py-6 sm:px-6 lg:px-8">
      <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Lesson Content</h2>
        <p class="text-gray-700">{{ lesson.content }}</p>
      </div>
    </div>

     <!-- Display Questions -->
    <div class="px-4 py-6 sm:px-6 mb-20 lg:px-8" v-if="questions.length">
      <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-3">Questions Asked</h2>
        <ul class="space-y-2">
          <li v-for="q in questions" :key="q.id" class="border-b pb-2 text-gray-800">
            - {{ q.content }}
          </li>
        </ul>
      </div>
    </div>

   <!-- Ask a Question  -->
<div class="fixed bottom-0  left-0 w-full bg-white shadow-md border-t z-50  py-4">
  <div class="max-w-6xl mx-auto">
    <h2 class="text-lg font-semibold mb-2">Ask a Question</h2>
    <div class="flex flex-col sm:flex-row items-center gap-4">
      <Input
        id="question"
        name="question"
        v-model="questionInput"
        type="text"
        placeholder="Type your question here..."
        class="w-full sm:w-3/4"
      />
      <button
        @click="submitQuestion"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
      >
        Submit
      </button>
    </div>
  </div>
</div>


   
  </AuthenticatedLayout>
</template>
