<template>
    <DashboardLayout :userRole="$page.props.userRole">
        <header class="py-4">
          <div class="container mx-auto flex justify-between items-center px-9">
            <h1 class="text-gray-800 font-bold">
              {{ activeMenu === 'home' ? 'Home' : activeMenu === 'kelola' ? 'Kelola Data' : 'Register Akun' }}
            </h1>
            <div class="flex items-center gap-2">
              <div class="relative">
                <input type="text" v-model="searchQuery" placeholder="Search..." class="search-input" />
                <button @click="handleSearch" class="search-button absolute inset-y-0 right-0 flex items-center pr-3">🔍</button>
              </div>
              <button @click="addNew" class="add-new-button">Add New</button>
            </div>
          </div>
        </header>
  
        <nav class="tabs mt-4 flex space-x-4">
          <a href="#" @click="setTab('all')" :class="{ 'active-tab': currentTab === 'all' }">All</a>
          <a href="#" @click="setTab('ongoing')" :class="{ 'active-tab': currentTab === 'ongoing' }">On Going</a>
          <a href="#" @click="setTab('approved')" :class="{ 'active-tab': currentTab === 'approved' }">Approved</a>
          <a href="#" @click="setTab('rejected')" :class="{ 'active-tab': currentTab === 'rejected' }">Rejected</a>
        </nav>
  
        <table class="data-table mt-4">
          <thead>
            <tr>
              <th>NIK</th>
              <th>Nama</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="filteredItems.length === 0">
              <td colspan="4" class="text-center">Data Not Found</td>
            </tr>
            <tr v-for="item in filteredItems" :key="item.id">
              <td>{{ item.nik }}</td>
              <td>{{ item.nama }}</td>
              <td>{{ item.status }}</td>
              <td>
                <button class="dropdown-button" @click="handleDropdownClick(item)">•••</button>
              </td>
            </tr>
          </tbody>
        </table>
    </DashboardLayout>
  </template>
  
  <script setup>
  import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { ref, computed } from 'vue';
import { defineProps } from 'vue';
  
  const activeMenu = ref('home');
  const searchQuery = ref('');
  const currentTab = ref('all');
  
  

const props = defineProps({
    role: String // Mengakses prop role dari Inertia
});

  const items = ref([
    { id: 1, nik: '123456', nama: 'John Doe', status: 'ongoing' },
    { id: 2, nik: '234567', nama: 'Jane Smith', status: 'approved' },
    { id: 3, nik: '345678', nama: 'Alice Johnson', status: 'rejected' },
  ]);
  
  function setActiveMenu(menu) {
    activeMenu.value = menu;
  }
  
  function handleSearch() {
    // Search function (no additional logic needed with v-model binding)
  }
  
  function addNew() {
    console.log('Adding new item');
  }
  
  function setTab(tab) {
    currentTab.value = tab;
  }
  
  const filteredItems = computed(() => {
    return items.value.filter(item => {
      const matchesSearch = item.nama.toLowerCase().includes(searchQuery.value.toLowerCase());
      const matchesTab = currentTab.value === 'all' || item.status.toLowerCase() === currentTab.value;
      return matchesSearch && matchesTab;
    });
  });
  
  function handleDropdownClick(item) {
    console.log('Dropdown clicked for item:', item);
  }
  </script>

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
  