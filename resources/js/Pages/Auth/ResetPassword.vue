<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'

// Ambil token dari URL atau props
const props = defineProps({
  token: String,
  email: String
})

const form = useForm({
  token: props.token,
  email: props.email || '',
  password: '',
  password_confirmation: '',
})

const showPassword = ref(false)
const showConfirmPassword = ref(false)

const passwordMismatch = computed(() => 
  form.password && form.password_confirmation && 
  form.password !== form.password_confirmation
)

const togglePasswordVisibility = (type) => {
  if (type === 'password') {
    showPassword.value = !showPassword.value
  } else {
    showConfirmPassword.value = !showConfirmPassword.value
  }
}

const submit = () => {
  form.post(route('password.store'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>

<template>
  <div class="min-h-screen flex flex-col bg-gray-100">
    <header class="w-full bg-red-950 bg-opacity-90 h-[39px]"></header>
    <main class="flex flex-col items-center w-full max-w-[508px] mx-auto px-4 mt-14 max-md:mt-10">
      <!-- Navigation -->
      <nav class="flex items-center self-start gap-2 mb-8">
        <img
          loading="lazy"
          src="https://cdn.builder.io/api/v1/image/assets/40e02fd5b45d48cd9235b37b246a760e/941293f1bd9ae0c2615d0ccc1569dccf253136fb8156a96ca0fb60256dbfa318?apiKey=40e02fd5b45d48cd9235b37b246a760e&"
          alt="Back"
          class="object-contain w-3"
        />
        <a :href="route('login')" class="text-indigo-950 font-medium hover:underline">
          Back
        </a>
      </nav>

      <!-- Heading -->
      <h1 class="text-2xl font-bold text-red-950 mb-4 max-md:text-xl">
        Reset Your Password
      </h1>
      <p class="text-sm text-gray-600 text-center mb-8 max-md:text-xs">
        Please enter your email and create a new password.
      </p>

      <!-- Form -->
      <form @submit.prevent="submit" class="w-full space-y-6 bg-white p-6 rounded-md shadow-md">
        <!-- Email -->
        <div class="w-full">
          <InputLabel for="email" value="Email address" />
          <TextInput
            id="email"
            type="email"
            v-model="form.email"
            required
            class="mt-1 block w-full"
            placeholder="Enter your email address"
            :disabled="!!props.email"
          />
          <InputError :message="form.errors.email" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="w-full">
          <InputLabel for="password" value="Password" />
          <div class="relative">
            <TextInput
              id="password"
              :type="showPassword ? 'text' : 'password'"
              v-model="form.password"
              required
              minlength="8"
              class="mt-1 block w-full"
              placeholder="Create a password (min. 8 characters)"
            />
            <button
              type="button"
              @click="togglePasswordVisibility('password')"
              class="absolute right-3 top-3 text-gray-500 focus:outline-none"
            >
              <span v-if="showPassword">🙈</span>
              <span v-else>👁️</span>
            </button>
          </div>
          <InputError :message="form.errors.password" class="mt-2" />
          <p v-if="form.password && form.password.length < 8" class="text-red-600 text-sm mt-2">
            Password must be at least 8 characters.
          </p>
        </div>

        <!-- Confirm Password -->
        <div class="w-full">
          <InputLabel for="password_confirmation" value="Confirm Password" />
          <div class="relative">
            <TextInput
              id="password_confirmation"
              :type="showConfirmPassword ? 'text' : 'password'"
              v-model="form.password_confirmation"
              required
              class="mt-1 block w-full"
              placeholder="Confirm your password"
            />
            <button
              type="button"
              @click="togglePasswordVisibility('confirm')"
              class="absolute right-3 top-3 text-gray-500 focus:outline-none"
            >
              <span v-if="showConfirmPassword">🙈</span>
              <span v-else>👁️</span>
            </button>
          </div>
          <p v-if="passwordMismatch" class="text-red-600 text-sm mt-2">
            Password and Confirm Password do not match!
          </p>
        </div>

        <!-- Submit Button -->
        <PrimaryButton 
          class="w-full py-3"
          :disabled="form.processing || passwordMismatch || form.password.length < 8"
        >
          Reset Password
        </PrimaryButton>
      </form>
    </main>
  </div>
</template>

<style scoped>
/* Responsive Design Adjustments */
@media (max-width: 768px) {
  .shadow-md {
    box-shadow: none;
  }
}
</style>