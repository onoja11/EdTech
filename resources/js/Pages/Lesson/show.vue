<script setup>
import { ref } from 'vue'
import { Head, Link  } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import primary from '@/Components/PrimaryButton.vue'

defineProps({
  lesson: Object,
  created_by: Object,
  questions: Object,
  recommendations: Object,
  user_role:Object,
})

const prompt = ref('')
const response = ref('')
const loading = ref(false)
const currentRecommendations = ref([])

// Track expanded state for each question response
const expandedResponses = ref({})

const askGemini = async (lessonId) => {
  if (!prompt.value.trim()) return
  loading.value = true
  response.value = ''
  currentRecommendations.value = []
  
  try {
    const res = await axios.post('/generate', { 
      prompt: prompt.value, 
      lesson_id: lessonId 
    })
    
    response.value = res.data?.candidates?.[0]?.content?.parts?.[0]?.text || 'No response'
    currentRecommendations.value = res.data?.recommendations || []
    
    // Clear the prompt after successful response
    prompt.value = ''
    
  } catch (error) {
    console.error(error)
    response.value = 'An error occurred while contacting the AI assistant.'
  } finally {
    loading.value = false
  }
}

// Function to toggle expanded state
const toggleExpanded = (questionId) => {
  expandedResponses.value[questionId] = !expandedResponses.value[questionId]
}

// Function to truncate text
const truncateText = (text, maxLength = 200) => {
  if (text.length <= maxLength) return text
  return text.substring(0, maxLength) + '...'
}

// Function to check if text needs truncation
const needsTruncation = (text, maxLength = 200) => {
  return text.length > maxLength
}

// Auto-resize textarea
const autoResize = (event) => {
  const textarea = event.target
  textarea.style.height = 'auto'
  textarea.style.height = textarea.scrollHeight + 'px'
}
</script>

<template>
  <Head :title="lesson.title" />
  
  <AuthenticatedLayout>
    <div class="min-h-screen bg-gradient-to-br from-yellow-50 via-amber-50 to-orange-50">
      <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="relative mb-8">
          <div class="bg-gradient-to-r from-yellow-400 via-amber-400 to-orange-400 rounded-3xl p-8 text-center shadow-xl relative overflow-hidden">
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
        <div class="bg-white relative rounded-3xl shadow-2xl p-8 mb-8 border border-yellow-200">
          <div class="flex items-center mb-6">
            <!-- Book SVG -->
            <svg width="32" height="32" viewBox="0 0 24 24" class="text-amber-600 mr-3">
              <path d="M4 2h16a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z" stroke="currentColor" stroke-width="2" fill="none"/>
              <path d="M8 6h8M8 10h8M8 14h5" stroke="currentColor" stroke-width="2"/>
            </svg>
            <h2 class="text-3xl font-bold text-gray-800">Lesson Content</h2>
            <div class="md:absolute end-9"  v-if="user_role == 'admin'">
              <Link
              :href="`/lessonContent/${lesson.id}/edit`">
                <primary>edit content</primary>
              </Link>
            </div>
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
            <h2 class="text-3xl font-bold text-gray-800">Ask Your AI Study Buddy</h2>
          </div>
          
          <div class="bg-gradient-to-r from-yellow-50 to-amber-50 rounded-2xl p-6 mb-6 border-2 border-yellow-200">
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2">
                 What would you like to know about this lesson?
              </label>
              <textarea
                v-model="prompt"
                @input="autoResize"
                rows="3"
                placeholder="Ask me anything about this lesson content..."
                class="w-full p-4 border-2 border-yellow-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-yellow-200 focus:border-amber-400 text-gray-800 placeholder-gray-500 text-lg resize-none transition-all duration-200"
              ></textarea>
            </div>
            
            <button
              @click="askGemini(lesson.id)"
              :disabled="loading"
              class="bg-gradient-to-r from-amber-400 to-yellow-500 hover:from-amber-500 hover:to-yellow-600 disabled:from-gray-300 disabled:to-gray-400 text-white px-8 py-4 rounded-xl transition-all duration-300 transform hover:scale-105 disabled:hover:scale-100 font-semibold text-lg shadow-lg"
            >
              <span v-if="loading" class="flex items-center justify-center">
                <!-- Loading spinner SVG -->
                <svg class="animate-spin -ml-1 mr-3 h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Reading lesson content and thinking...
              </span>
              <span v-else class="flex items-center justify-center">
                <!-- Send SVG -->
                <svg width="24" height="24" viewBox="0 0 24 24" class="mr-3" fill="currentColor">
                  <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                </svg>
                Ask About This Lesson
              </span>
            </button>
          </div>

          <!-- AI Response -->
          <div v-if="response" class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-2xl p-6 mb-6 animate-fade-in">
            <div class="flex items-center mb-4">
              <!-- AI Success SVG -->
              <svg width="28" height="28" viewBox="0 0 24 24" class="text-green-600 mr-3">
                <circle cx="12" cy="12" r="10" fill="currentColor"/>
                <path d="m9 12 2 2 4-4" stroke="white" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              <h3 class="text-2xl font-bold text-green-800">AI Study Buddy Says:</h3>
            </div>
            <div class="bg-white rounded-xl p-4 border border-green-200">
              <p class="text-gray-800 whitespace-pre-wrap text-lg leading-relaxed">{{ response }}</p>
            </div>
          </div>

          <!-- Lesson Recommendations -->
          <div v-if="currentRecommendations && currentRecommendations.length" class="bg-gradient-to-r from-purple-50 to-pink-50 border-2 border-purple-200 rounded-2xl p-6 mb-6 animate-fade-in">
            <div class="flex items-center mb-4">
              <!-- Lightbulb SVG -->
              <svg width="28" height="28" viewBox="0 0 24 24" class="text-purple-600 mr-3">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 2.38 1.19 4.47 3 5.74V17c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-2.26c1.81-1.27 3-3.36 3-5.74 0-3.87-3.13-7-7-7zm2.85 11.1l-.85.6V16h-4v-2.3l-.85-.6C7.8 12.16 7 10.63 7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 1.63-.8 3.16-2.15 4.1z" fill="currentColor"/>
              </svg>
              <h3 class="text-2xl font-bold text-purple-800">Other Lessons That Might Help</h3>
            </div>
            
            <div class="space-y-4">
              <div 
                v-for="(recommendation, index) in currentRecommendations" 
                :key="index"
                class="bg-white rounded-xl p-5 shadow-md border border-purple-100 hover:shadow-lg transition-all duration-300 hover:border-purple-300"
              >
                <div class="flex items-start justify-between">
                  <div class="flex-1">
                    <div class="flex items-center mb-2">
                      <!-- Book Icon -->
                      <svg width="20" height="20" viewBox="0 0 24 24" class="text-purple-600 mr-2">
                        <path d="M4 2h16a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z" stroke="currentColor" stroke-width="2" fill="none"/>
                      </svg>
                      <h4 class="text-xl font-bold text-gray-800">{{ recommendation.lesson.title }}</h4>
                    </div>
                    
                    <div class="flex items-center mb-3">
                      <!-- Subject Tag -->
                      <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800 mr-3">
                        <svg width="16" height="16" viewBox="0 0 24 24" class="mr-1">
                          <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" fill="currentColor"/>
                        </svg>
                        {{ recommendation.lesson.subject }}
                      </span>
                    </div>
                    
                    <p class="text-gray-700 mb-4 italic">
                      <span class="font-medium">Why this might help:</span> {{ recommendation.reason }}
                    </p>
                  </div>
                  
                  <div class="ml-4 flex-shrink-0">
                    <Link
                      :href="`/lessons/${recommendation.lesson.id}`"
                      class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-medium rounded-lg transition-all duration-300 transform hover:scale-105 shadow-md"
                    >
                      <svg width="18" height="18" viewBox="0 0 24 24" class="mr-2" fill="currentColor">
                        <path d="M13 3l3.293 3.293-7 7 1.414 1.414 7-7L21 11V3z"/>
                        <path d="M19 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h6"/>
                      </svg>
                      View Lesson
                    </Link>
                  </div>
                </div>
              </div>
            </div>
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
            
            <div class="space-y-4 max-h-96 overflow-y-auto">
              <div 
                v-for="question in questions" 
                :key="question.id"
                class="bg-white rounded-xl p-5 shadow-md border border-blue-100 hover:shadow-lg transition-shadow duration-300"
              >
                <div class="flex items-start mb-3">
                  <div class="rounded-full bg-blue-500 w-3 h-3 mr-3 mt-2 flex-shrink-0"></div>
                  <div class="flex-1">
                    <p class="font-bold text-gray-800 mb-2">You asked:</p>
                    <p class="text-gray-700 mb-4 bg-blue-50 p-3 rounded-lg italic">{{ question.question }}</p>
                  </div>
                </div>
                
                <div class="flex items-start">
                  <div class="rounded-full bg-green-500 w-3 h-3 mr-3 mt-2 flex-shrink-0"></div>
                  <div class="flex-1">
                    <p class="font-bold text-gray-800 mb-2">AI Response:</p>
                    <div class="bg-green-50 p-3 rounded-lg">
                      <p class="text-gray-700 leading-relaxed">
                        <!-- Show truncated or full text based on expanded state -->
                        <template v-if="expandedResponses[question.id] || !needsTruncation(question.ai_response)">
                          {{ question.ai_response }}
  </template>
                        <template v-else>
                          {{ truncateText(question.ai_response) }}
                        </template>
                      </p>
                      
                      <!-- Read More/Read Less Button -->
                      <button
                        v-if="needsTruncation(question.ai_response)"
                        @click="toggleExpanded(question.id)"
                        class="mt-3 text-green-600 hover:text-green-800 font-medium text-sm flex items-center transition-colors duration-200 group"
                      >
                        <template v-if="expandedResponses[question.id]">
                          <!-- Read Less Icon -->
                          <svg width="16" height="16" viewBox="0 0 24 24" class="mr-1 transform group-hover:-translate-y-0.5 transition-transform">
                            <path d="M7 14l5-5 5 5z" fill="currentColor"/>
                          </svg>
                          Read Less
                        </template>
                        <template v-else>
                          <!-- Read More Icon -->
                          <svg width="16" height="16" viewBox="0 0 24 24" class="mr-1 transform group-hover:translate-y-0.5 transition-transform">
                            <path d="M7 10l5 5 5-5z" fill="currentColor"/>
                          </svg>
                          Read More
                        </template>
                      </button>
                    </div>
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