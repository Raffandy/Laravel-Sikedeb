<template>
  <main class="flex overflow-hidden flex-col items-center pb-40 text-xs bg-white max-md:pb-24">
    <header class="flex self-stretch w-full bg-red-950 bg-opacity-90 min-h-[39px] max-md:max-w-full"></header>
    <div class="flex shrink-0 mt-12 max-w-full rounded-xl bg-red-950 bg-opacity-90 h-[7px] w-[280px] max-md:mt-10"></div>
    <section class="flex flex-col items-center w-full max-w-[508px]">
      <h1 class="mt-24 text-xl font-bold text-slate-900 text-opacity-90 max-md:mt-10">Sign Up</h1>
      <p class="text-black text-opacity-50">Create User Account</p>
      <form @submit.prevent="submit" class="w-full mt-4 space-y-3">
        <div class="space-y-4 w-full">
          <div>
            <label for="name" class="block mb-1 text-slate-700">Full Name</label>
            <input
              id="name"
              type="text"
              placeholder="Enter your full name"
              v-model="form.name"
              class="w-full rounded-sm border border-solid border-black border-opacity-50 h-[41px] px-3"
              required
            />
          </div>
          <div>
            <label for="email" class="block mb-1 text-slate-700">Email</label>
            <input
              id="email"
              type="email"
              placeholder="Enter your email"
              v-model="form.email"
              class="w-full rounded-sm border border-solid border-black border-opacity-50 h-[41px] px-3"
              required
            />
          </div>
          <div>
            <label for="password" class="block mb-1 text-slate-700">Password</label>
            <input
              id="password"
              type="password"
              placeholder="Enter your password"
              v-model="form.password"
              class="w-full rounded-sm border border-solid border-black border-opacity-50 h-[41px] px-3"
              required
            />
          </div>
          <div>
            <label for="password_confirmation" class="block mb-1 text-slate-700">Confirm Password</label>
            <input
              id="password_confirmation"
              type="password"
              placeholder="Confirm your password"
              v-model="form.password_confirmation"
              class="w-full rounded-sm border border-solid border-black border-opacity-50 h-[41px] px-3"
              required
            />
          </div>
        </div>
        <div class="flex justify-center mt-16 w-full">
          <button type="submit" class="px-6 py-3 text-white bg-red-900 rounded-sm" :disabled="form.processing">
            Sign up
          </button>
        </div>
        
      </form>
    </section>
  </main>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route('register'), {
    onError: () => {
      console.error('Form submission failed', form.errors);
    },
  });
};
</script>

<style scoped>
.builder-component {
  max-width: none !important;
}
</style>
