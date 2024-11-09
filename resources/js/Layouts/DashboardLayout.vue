<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    role: String // Mengakses prop role dari Inertia
});
</script>

<template>
    <div class="flex overflow-hidden bg-white">
      <!-- Sidebar -->
      <aside class="sidebar bg-gray-100 w-64">
        <div class="flex items-center gap-4 p-4 text-xs font-extrabold text-white bg-red-950 rounded-lg">
          <img src="../../../public/assets/Exclude.png" alt="Logo" class="object-contain w-[20px]" />
          <span>$IKEDEB</span>
        </div>
        <router-link
          to="/"
          class="sidebar-link"
          :class="{ 'active': activeMenu === 'home' }"
          @click="setActiveMenu('home')"
        >
          <img src="../../../public/assets/Vector.png" alt="Home Icon" class="icon" /> Home
        </router-link>
        <router-link
          to="/kelola-data"
          class="sidebar-link"
          :class="{ 'active': activeMenu === 'kelola' }"
          @click="setActiveMenu('kelola')"
        >
          <img src="../../../public/assets/Icon.png" alt="Kelola Data Icon" class="icon" /> Kelola Data
        </router-link>
        <router-link
          v-if="role === 'admin'"
          to="/SignUpForm"
          class="sidebar-link"
          :class="{ 'active': activeMenu === 'register' }"
          @click="setActiveMenu('register')"
        >
          <img src="../../../public/assets/Register.png" alt="Register Icon" class="icon" /> Register Akun
        </router-link>
      </aside>
  
      <!-- Main Content -->
      <main class="flex-1 p-5">
        <slot/>
      </main>
    </div>
</template>

<script>
export default {
  computed: {
    userRole() {
      return this.$page.props.userRole; // Mengambil data dari Inertia share
    },
  },
};
</script>

<style scoped>
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
  
  .search-input {
    border: 1px solid #ddd;
    padding: 0.5rem;
    padding-right: 2.5rem;
  }
  
  .search-button {
    background-color: transparent;
    border: none;
    cursor: pointer;
  }
  
  .add-new-button {
    background-color: #3b82f6;
    color: #fff;
    padding: 0.5rem 1rem;
    border-radius: 5px;
  }
  
  .active-tab {
    font-weight: bold;
    color: #230202;
  }
  
  .tabs {
    margin-top: 1rem;
  }
  
  .tabs a {
    padding: 0.5rem 1rem;
    border-radius: 5px;
    text-decoration: none;
    color: #333;
    transition: background-color 0.3s;
  }
  .tabs a:hover {
    background-color: red;
    color: white;
  }
  
  .data-table {
    width: 100%;
    border-collapse: collapse;
  }
  .data-table th,
  .data-table td {
    border: 1px solid #ddd;
    padding: 0.5rem;
  }
  
  .dropdown-button {
    border: none;
    background: none;
    cursor: pointer;
    font-size: 1.5rem;
    line-height: 1;
  }
  </style>