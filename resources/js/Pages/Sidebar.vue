<template>
    <div class="flex overflow-hidden bg-white">
      <aside class="sidebar bg-gray-100 w-64 flex flex-col">
        <!-- Logo Section -->
        <div class="flex items-center gap-4 p-4 text-xs font-extrabold text-white bg-red-950 rounded-lg">
          <img src="../../../public/assets/Exclude.png" alt="Logo" class="object-contain w-[20px]" />
          <span>$IKEDEB</span>
        </div>
        
        <!-- Sidebar Links -->
        <a href="/dashboard/data" class="sidebar-link" :class="{'active': activeMenu === 'home'}" @click="setActiveMenu('home')">
        <img src="../../../public/assets/Vector.png" alt="Home Icon" class="icon" /> 
        Home
        </a>
  
        <!-- Admin-specific Menu Items -->
        <a v-if="role === 'admin'" href="/kelola-admin" class="sidebar-link" :class="{'active': activeMenu === 'kelola'}" @click="setActiveMenu('kelola')">
          <img src="../../../public/assets/Icon.png" alt="Kelola Data Icon" class="icon" /> 
          Kelola Data
        </a>
  
        <a v-if="role === 'admin'" href="/profil-standar" class="sidebar-link" :class="{'active': activeMenu === 'profil standar'}" @click="setActiveMenu('profil standar')">
          <img src="../../../public/assets/IconPenilaian.png" alt="Penilaian Icon" class="icon" /> 
          Profil Standar
        </a>
  
        <a v-if="role === 'admin'" href="/register" class="sidebar-link" :class="{'active': activeMenu === 'register'}" @click="setActiveMenu('register')">
          <img src="../../../public/assets/Register.png" alt="Register Icon" class="icon" /> 
          Registrasi User
        </a>
  
        <!-- Flex Grow to Push Profile to Bottom -->
        <div class="flex-grow"></div>
  
        <!-- User Profile Section (at the bottom) -->
        <div class="user-profile mt-4 p-4 cursor-pointer" @click="toggleProfileModal">
          <div class="flex items-center gap-2 p-2 border-t-2 border-gray-200 hover:bg-gray-100 rounded-lg">
            <img src="../../../public/assets/user.png" alt="Profile Icon" class="icon" />
            <span class="text-sm font-medium">{{ username }}</span>
          </div>
        </div>
      </aside>
    </div>
  
    <!-- User Profile Modal -->
      <div v-if="profileModalOpen" class="profile-modal fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg w-80 shadow-lg">
          <h2 class="text-xl font-bold mb-4">User Profile</h2>
          <p v-if="role === 'user'" p class="text-sm text-gray-600 mb-4">ID Petugas: {{ user.id }}</p>
          <p class="text-sm text-gray-600 mb-4">Name: {{ username }}</p>
          <p class="text-sm text-gray-600 mb-4">Email: {{ email }}</p>
          <p class="text-sm text-gray-600 mb-4">Keterangan: {{ role }}</p>
          <button @click="Inertia.get(route('profile.edit'));" class="cancel-button mt-2 w-full bg-blue-300 text-black py-2 rounded">Profil</button>
          <button @click="Inertia.post(route('logout'));" class="logout-button mt-4 w-full bg-red-500 text-white py-2 rounded">Logout</button>
          <button @click="toggleProfileModal" class="cancel-button mt-2 w-full bg-gray-300 text-black py-2 rounded">Cancel</button>
        </div>
      </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { Inertia } from '@inertiajs/inertia';
  
  // Sidebar State
  const activeMenu = ref('profil standar');
  const email = ref('admin@gmai.com');
  const role = ref('admin'); // Set role dynamically or pass it as prop
  const username = ref('admin'); // Example username, can be dynamic as well
  const profileModalOpen = ref(false); // Profile modal visibility state
  
  // Set the active menu
  const setActiveMenu = (menu) => {
    activeMenu.value = menu;
  };
  
  // Toggle profile modal visibility
  const toggleProfileModal = () => {
    profileModalOpen.value = !profileModalOpen.value;
  };
  </script>
  
  <style scoped>
  /* Your existing styles */
  .sidebar {
    padding: 1rem;
    height: 100vh;
  }
  
  .sidebar-link {
    display: flex;
    align-items: center;
    padding: 1rem;
    text-decoration: none;
    color: #333;
    transition: color 0.3s;
  }
  
  .sidebar-link.active {
    color: blue;
  }
  
  .sidebar-link:hover {
    background-color: #f0f0f0;
  }
  
  .icon {
    width: 20px;
    margin-right: 0.5rem;
  }
  
  .user-profile {
    margin-top: 1rem;
  }
  </style>