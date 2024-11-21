<template>
  <main data-layername="signIn" class="flex overflow-hidden flex-col pb-80 text-xs bg-white max-md:pb-24">
    <header class="flex w-full bg-red-950 bg-opacity-90 min-h-[39px] max-md:max-w-full"></header>
    <section class="flex flex-col self-center mt-14 max-w-full w-[508px] max-md:mt-10">
      <nav class="flex gap-3.5 self-start whitespace-nowrap text-indigo-950">
        <img
          loading="lazy"
          src="https://cdn.builder.io/api/v1/image/assets/40e02fd5b45d48cd9235b37b246a760e/941293f1bd9ae0c2615d0ccc1569dccf253136fb8156a96ca0fb60256dbfa318?apiKey=40e02fd5b45d48cd9235b37b246a760e&"
          alt=""
          class="object-contain shrink-0 my-auto w-2 aspect-[0.8]"
        />
        <a href="#" data-layername="back">Back</a>
      </nav>
      <h1 data-layername="signIn" class="self-center mt-20 text-xl font-bold text-slate-900 text-opacity-90 max-md:mt-10">
        Sign In
      </h1>
      <p data-layername="signInWithYourDetailToContinue" class="self-center text-black text-opacity-50">
        Sign in with your details to continue
      </p>
      <form @submit.prevent="handleSubmit" class="flex flex-col w-full">
        <label for="email" class="mt-4 mb-1 text-slate-700">Email</label>
        <input
          v-model="form.email"
          type="email"
          id="email"
          placeholder="Enter your email"
          class="mt-1 w-full rounded-sm border border-solid border-black border-opacity-50 h-[41px] px-3"
          required
        />
        <label for="password" class="mt-4 mb-1 text-slate-700">Password</label>
        <input
          v-model="form.password"
          type="password"
          id="password"
          placeholder="Enter your password"
          class="mt-1 w-full rounded-sm border border-solid border-black border-opacity-50 h-[41px] px-3"
          required
        />
        <a href="#" data-layername="forgotPassword" class="self-start mt-5 text-blue-600">
          Forgot password?
        </a>
        <p v-if="errorMessage" class="mt-3 text-red-600">{{ errorMessage }}</p>
        <button
          type="submit"
          data-layername="signIn"
          class="px-12 py-3 mt-7 text-white rounded-sm bg-red-950 bg-opacity-90 max-md:px-5 max-md:max-w-full"
        >
          Sign in
        </button>
      </form>
      <footer class="flex gap-1 self-start mt-7">
        <p data-layername="dontHaveAnAccount" class="grow text-black text-opacity-50">
          Don't have an account?
        </p>
        <a href="#" data-layername="signUp" class="text-blue-600">Sign up</a>
      </footer>
    </section>
  </main>
</template>

<script setup>
import { ref } from "vue";

const form = ref({
  email: "",
  password: "",
});

const errorMessage = ref("");

const handleSubmit = () => {
  // Check if password length is at least 8 characters
  if (form.value.password.length < 8) {
    errorMessage.value = "Password must be at least 8 characters.";
    return;
  }

  // Check if email is valid
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(form.value.email)) {
    errorMessage.value = "Please enter a valid email address.";
    return;
  }

  // Simulate validation between email and password for synchronization rules
  if (!validateEmailPassword(form.value.email, form.value.password)) {
    errorMessage.value = "Email and password do not meet the synchronization rules.";
    return;
  }

  errorMessage.value = ""; // Reset error message if all checks pass
  alert("Form submitted successfully!"); // Placeholder for form submission logic
};

// Example function to validate "synchronization" between email and password
const validateEmailPassword = (email, password) => {
  // Example rule: Password cannot contain the email local part (before '@')
  const emailLocalPart = email.split("@")[0];
  return !password.includes(emailLocalPart);
};
</script>

<style scoped>
.builder-component {
  max-width: none !important;
}
</style>
