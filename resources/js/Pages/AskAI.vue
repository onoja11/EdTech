<!-- resources/js/Pages/AskAI.vue -->
<template>
  <div class="p-4">
    <h1 class="text-xl font-bold mb-4">Ask AI</h1>
    <form @submit.prevent="askAI">
      <textarea v-model="question" class="w-full border p-2 mb-2" rows="4" placeholder="Type your question..."></textarea>
      <button class="bg-blue-500 text-white px-4 py-2 rounded" :disabled="loading">
        {{ loading ? 'Asking...' : 'Ask' }}
      </button>
    </form>
    <div v-if="answer" class="mt-4 p-4 border bg-gray-50">
      <strong>Answer:</strong> {{ answer }}
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      question: '',
      answer: '',
      loading: false,
    };
  },
  methods: {
    async askAI() {
      this.loading = true;
      this.answer = '';
      try {
        const response = await axios.post('/ask-ai', {
          question: this.question,
        });
        this.answer = response.data.choices[0].message.content;
      } catch (e) {
        this.answer = 'There was an error.';
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>
