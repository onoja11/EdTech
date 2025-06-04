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

const askGemini = async (lessonId) => {
  if (!prompt.value.trim()) return
  loading.value = true
  response.value = ''
  try {
    const res = await axios.post('/generate', { prompt: prompt.value, lesson_id: lessonId })
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
    <div class="min-h-screen bg-gradient-to-br from-yellow-50 via-amber-50 to-orange-50">
      <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section with Fun Wave SVG -->
        <div class="relative mb-8">
          <div class="bg-gradient-to-r from-yellow-400 via-amber-400 to-orange-400 rounded-3xl p-8 text-center shadow-xl relative overflow-hidden">
            <!-- Decorative Wave SVG -->
            <svg class="absolute top-0 left-0 w-full h-full opacity-20" viewBox="0 0 1200 120" preserveAspectRatio="none">
              <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" fill="rgba(255,255,255,0.3)"/>
            </svg>
            
            <!-- Sun SVG -->
            <div class="absolute top-4 right-8">
              <svg width="60" height="60" viewBox="0 0 60 60" class="text-yellow-200">
                <circle cx="30" cy="30" r="15" fill="currentColor"/>
                <g stroke="currentColor" stroke-width="3" stroke-linecap="round">
                  <line x1="30" y1="5" x2="30" y2="10"/>
                  <line x1="30" y1="50" x2="30" y2="55"/>
                  <line x1="5" y1="30" x2="10" y2="30"/>
                  <line x1="50" y1="30" x2="55" y2="30"/>
                  <line x1="12.93" y1="12.93" x2="16.76" y2="16.76"/>
                  <line x1="43.24" y1="43.24" x2="47.07" y2="47.07"/>
                  <line x1="12.93" y1="47.07" x2="16.76" y2="43.24"/>
                  <line x1="43.24" y1="16.76" x2="47.07" y2="12.93"/>
                </g>
              </svg>
            </div>
            
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-2 relative z-10">{{ lesson.title }}</h1>
            <h2 class="text-xl md:text-2xl font-semibold text-yellow-100 mb-2 relative z-10">{{ lesson.subject }}</h2>
            <div class="flex items-center justify-center relative z-10">
              <!-- Teacher SVG -->
              <svg width="24" height="24" viewBox="0 0 24 24" class="text-yellow-100 mr-2">
                <circle cx="12" cy="6" r="4" fill="currentColor"/>
                <path d="m20 17.5c0 2.485 0 4.5-8 4.5s-8-2.015-8-4.5c0-2.485 3.582-4.5 8-4.5s8 2.015 8 4.5z" fill="currentColor"/>
              </svg>
              <p class="text-lg text-yellow-100 font-medium">by {{ created_by.name }}</p>
            </div>
          </div>
        </div>

        <!-- Lesson Content Card -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 mb-8 border border-yellow-200">
          <div class="flex items-center mb-6">
            <!-- Book SVG -->
            <svg width="32" height="32" viewBox="0 0 24 24" class="text-amber-600 mr-3">
              <path d="M4 2h16a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z" stroke="currentColor" stroke-width="2" fill="none"/>
              <path d="M8 6h8M8 10h8M8 14h5" stroke="currentColor" stroke-width="2"/>
            </svg>
            <h2 class="text-3xl font-bold text-gray-800">Lesson Content</h2>
          </div>
          
          <div class="bg-gradient-to-r from-yellow-50 to-amber-50 rounded-2xl p-4 border-2 border-yellow-200">
            <iframe
              :src="`/storage/${lesson.content}#toolbar=0`"
              width="100%"
              height="600px"
              class="border-0 rounded-xl shadow-lg"
            ></iframe>
          </div>
        </div>

        <!-- AI Assistant Section -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 border border-yellow-200">
          <div class="flex items-center mb-6">
            <!-- Brain/AI SVG -->
            <svg width="32" height="32" viewBox="0 0 24 24" class="text-amber-600 mr-3">
              <path d="M12 2C8.5 2 6 4.5 6 8c0 1.5.5 3 1.5 4C6 13.5 5 15.5 5 18c0 2.5 2.5 4 5.5 4h3c3 0 5.5-1.5 5.5-4 0-2.5-1-4.5-2.5-6 1-1 1.5-2.5 1.5-4 0-3.5-2.5-6-6-6z" fill="currentColor"/>
              <circle cx="9" cy="8" r="1" fill="white"/>
              <circle cx="15" cy="8" r="1" fill="white"/>
            </svg>
            <h2 class="text-3xl font-bold text-gray-800">Ask Your AI Study Buddy</h2>
          </div>
          
          <div class="bg-gradient-to-r from-yellow-50 to-amber-50 rounded-2xl p-6 mb-6 border-2 border-yellow-200">
            <textarea
              v-model="prompt"
              rows="4"
              placeholder="What would you like to know about this lesson? Ask me anything! 🤔"
              class="w-full p-4 border-2 border-yellow-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-yellow-200 focus:border-amber-400 text-gray-800 placeholder-gray-500 text-lg"
            ></textarea>
            
            <button
              @click="askGemini(lesson.id)"
              :disabled="loading"
              class="mt-4 bg-gradient-to-r from-amber-400 to-yellow-500 hover:from-amber-500 hover:to-yellow-600 disabled:from-gray-300 disabled:to-gray-400 text-white px-8 py-3 rounded-xl transition-all duration-300 transform hover:scale-105 font-semibold text-lg shadow-lg"
            >
              <span v-if="loading" class="flex items-center">
                <!-- Loading spinner SVG -->
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Thinking...
              </span>
              <span v-else class="flex items-center">
                <!-- Send SVG -->
                <svg width="20" height="20" viewBox="0 0 24 24" class="mr-2" fill="currentColor">
                  <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                </svg>
                Ask Question
              </span>
            </button>
          </div>

          <!-- AI Response -->
          <div v-if="response" class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-2xl p-6 mb-6">
            <div class="flex items-center mb-3">
              <!-- Check/Success SVG -->
              <svg width="24" height="24" viewBox="0 0 24 24" class="text-green-600 mr-2">
                <circle cx="12" cy="12" r="10" fill="currentColor"/>
                <path d="m9 12 2 2 4-4" stroke="white" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              <h3 class="text-xl font-bold text-green-800">AI Study Buddy Says:</h3>
            </div>
            <p class="text-gray-800 whitespace-pre-wrap text-lg leading-relaxed">{{ response }}</p>
          </div>

          <!-- Question History -->
          <div v-if="questions && questions.length" class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-2xl p-6">
            <div class="flex items-center mb-4">
              <!-- History SVG -->
              <svg width="28" height="28" viewBox="0 0 24 24" class="text-blue-600 mr-3">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                <path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"/>
              </svg>
              <h3 class="text-2xl font-bold text-blue-800">Your Learning History</h3>
            </div>
            
            <div class="space-y-4">
              <div 
                v-for="question in questions" 
                :key="question.id"
                class="bg-white rounded-xl p-5 shadow-md border border-blue-100 hover:shadow-lg transition-shadow duration-300"
              >
                <div class="flex items-start mb-3">
                  <!-- Question SVG -->
                  <svg width="20" height="20" viewBox="0 0 24 24" class="text-blue-500 mr-2 mt-1 flex-shrink-0">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 17h.01" stroke="currentColor" stroke-width="2" fill="none"/>
                  </svg>
                  <div class="flex-1">
                    <p class="font-bold text-gray-800 mb-2">You asked:</p>
                    <p class="text-gray-700 mb-4 bg-blue-50 p-3 rounded-lg">{{ question.question }}</p>
                  </div>
                </div>
                
                <div class="flex items-start">
                  <!-- Answer SVG -->
                  <svg width="20" height="20" viewBox="0 0 24 24" class="text-green-500 mr-2 mt-1 flex-shrink-0">
                    <path d="M12 2C8.5 2 6 4.5 6 8c0 1.5.5 3 1.5 4C6 13.5 5 15.5 5 18c0 2.5 2.5 4 5.5 4h3c3 0 5.5-1.5 5.5-4 0-2.5-1-4.5-2.5-6 1-1 1.5-2.5 1.5-4 0-3.5-2.5-6-6-6z" fill="currentColor"/>
                  </svg>
                  <div class="flex-1">
                    <p class="font-bold text-gray-800 mb-2">AI Response:</p>
                    <p class="text-gray-700 bg-green-50 p-3 rounded-lg">{{ question.ai_response }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        
      </div>
    </div>
  </AuthenticatedLayout>
</template>