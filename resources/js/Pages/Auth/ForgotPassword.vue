<template>
  <div class="min-h-screen flex flex-col bg-white">
    <header class="w-full bg-red-950 bg-opacity-90 h-[39px]"></header>
    <main class="flex flex-col items-center w-full max-w-[508px] mx-auto px-4 mt-14 max-md:mt-10">
      <nav class="flex items-center self-start gap-2 mb-8">
        <img
          loading="lazy"
          src="https://cdn.builder.io/api/v1/image/assets/40e02fd5b45d48cd9235b37b246a760e/941293f1bd9ae0c2615d0ccc1569dccf253136fb8156a96ca0fb60256dbfa318?apiKey=40e02fd5b45d48cd9235b37b246a760e&"
          alt="Back"
          class="object-contain w-2"
        />
        <button @click.prevent="goBack" class="text-indigo-950 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500">
          Back
        </button>
      </nav>

      <h1 class="text-2xl font-bold text-red-950 mb-2 max-md:text-xl">
        Forgot your password?
      </h1>
      <p class="text-sm text-black text-opacity-70 text-center mb-6 max-md:text-xs">
        Enter the email address you used when you signed up, and we'll send you instructions on how to reset your password.
      </p>

      <form @submit.prevent="handleSubmit" class="w-full space-y-4">
        <div v-if="status" class="p-4 text-green-700 bg-green-100 border border-green-400 rounded">
          {{ status }}
        </div>
        <div v-if="form.errors.email" class="p-4 text-red-700 bg-red-100 border border-red-400 rounded">
          {{ form.errors.email }}
        </div>
        <div class="w-full">
          <label for="email" class="sr-only">Email address</label>
          <input
            id="email"
            type="email"
            v-model="form.email"
            required
            class="w-full rounded-md border border-gray-300 h-[42px] px-3 focus:border-red-500 focus:outline-none"
            placeholder="Enter your email"
          />
        </div>

        <button
          type="submit"
          class="w-full py-3 text-white rounded-md bg-red-950 bg-opacity-90 hover:bg-red-800 transition focus:outline-none focus:ring-2 focus:ring-red-500"
          :disabled="form.processing"
        >
          Reset password
        </button>
      </form>

    </main>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
  email: '',
});
const status = ref(null);

const goBack = () => {
  window.history.back();
};

const handleSubmit = () => {
  form.post(route('password.email'), {
    onSuccess: () => {
      status.value = 'Password reset link sent successfully.';
    },
    onError: () => {
      status.value = null;
    },
  });
};
</script>

<style scoped>
.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border-width: 0;
}
</style>
