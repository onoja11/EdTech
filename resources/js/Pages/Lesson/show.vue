<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineProps({
  lesson: Object,
  created_by: Object,
  questions: Object,
})

const prompt = ref('')
const response = ref('')
const loading = ref(false)

const askGemini = async () => {
  if (!prompt.value.trim()) return
  loading.value = true
  response.value = ''
  try {
    const res = await axios.post('/generate', { prompt: prompt.value })
    response.value = res.data?.candidates?.[0]?.content?.parts?.[0]?.text || 'No response'
  } catch (error) {
    console.error(error)
    response.value = 'An error occurred while contacting Gemini.'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <Head :title="lesson.title" />

  <AuthenticatedLayout>
    <div class="max-w-4xl mx-auto py-10 px-6">
      <div class="mb-4">
        <h1 class="text-3xl font-extrbold text-center">{{ lesson.title }}</h1>
      <h2 class="font-bold text-center"> {{ lesson.subject }}</h2>
      <p class="font-serif text-center"> {{ created_by.name }}</p>
      </div>
      <!-- Lesson Info -->
      <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-bold mb-2">Lessons Content</h2>
<iframe
      :src="`/storage/${lesson.content}#toolbar=0`"
      width="100%"
      height="600px"
      class="border rounded"
    ></iframe>      </div>

      <!-- Gemini Prompt -->
      <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Ask Gemini About This Lesson</h2>

        <textarea
          v-model="prompt"
          rows="4"
          placeholder="Type your question about this lesson..."
          class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
        ></textarea>

        <button
          @click="askGemini"
          :disabled="loading"
          class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded transition"
        >
          {{ loading ? 'Thinking...' : 'Submit' }}
        </button>

        <div v-if="response" class="mt-6 bg-gray-100 p-4 rounded shadow-sm">
          <h3 class="font-semibold mb-2 text-gray-700">Gemini's Response:</h3>
          <p class="text-gray-800 whitespace-pre-wrap">{{ response }}</p>
        </div>

        <div class="mt-6 p-4 rounded shadow-sm">
          <h3 class="font-semibold mb-2 text-gray-700">Gemini's History:</h3>
          <div class="bg-gray-50 rounded p-2 mb-2"  v-if="questions" v-for="question in questions"
          :key="question.id">
            <p class="text-gray-500 mb-2 capitalize"><span class="font-extrabold text-black">You Asked: </span>{{ question.question }}</p>
            <p class="text-gray-500 mb-2"><span class="font-extrabold text-black">Response: </span> {{ question.ai_response }}</p>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
