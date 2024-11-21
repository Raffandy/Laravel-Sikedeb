<template>
    <div class="flex overflow-hidden bg-white">
      <aside class="sidebar bg-gray-100 w-64">
        <div class="flex items-center gap-4 p-4 text-xs font-extrabold text-white bg-red-950 rounded-lg">
          <img src="../../../public/assets/Exclude.png" alt="Logo" class="object-contain w-[20px]" />
          <span>$IKEDEB</span>
        </div>
        <a href="#" class="sidebar-link" :class="{'active': activeMenu === 'penilaian kelayakan'}" @click="setActiveMenu('penilaian kelayakan')">
          <img src="../../../public/assets/IconPenilaian.png" alt="Penilaian Icon" class="icon" /> Penilaian Kelayakan
        </a>
      </aside>
  
      <main class="flex-1 p-5">
        <header class="py-4">
          <div class="container mx-auto flex justify-between items-center px-9">
            <h1 class="text-gray-800 font-bold">{{ activeMenu === 'home' ? 'Home' : 'Penilaian Kelayakan' }}</h1>
            <div class="flex items-center gap-2">
              <div class="relative">
                <input type="text" v-model="searchQuery" placeholder="Search..." class="search-input" />
                <button @click="handleSearch" class="search-button absolute inset-y-0 right-0 flex items-center pr-3">🔍</button>
              </div>
              <button @click="addNew" class="add-new-button">Add New</button>
            </div>
          </div>
        </header>
  
        <section class="mt-6">
          <h2 class="text-gray-800 font-semibold mb-4">Form Bobot Character</h2>
          <div class="form-group">
            <label for="sik-ojk" class="block text-gray-700 font mb-2">SLIK OJK</label>
            <select v-model="selectedOJK" id="sik-ojk" class="dropdown w-full p-2 border border-gray-300 rounded">
              <option value="5">SLIK OJK 1 (5 = Lancar)</option>
              <option value="4">SLIK OJK 2 (4 = Dalam Perhatian Khusus)</option>
              <option value="3">SLIK OJK 3 (3 = Kurang Lancar)</option>
              <option value="2">SLIK OJK 4 (2 = Diragukan)</option>
              <option value="1">SLIK OJK 5 (1 = Macet)</option>
            </select>
          </div>
  
          <!-- Bobot Capacity Form -->
          <h2 class="text-gray-800 font-semibold mb-4 mt-6">Form Bobot Capacity</h2>
          <div class="flex gap-4">
            <div class="form-group flex-1">
              <label for="pendapatan-utama" class="block text-gray-700 font mb-2">Pendapatan Utama</label>
              <select v-model="selectedPendapatanUtama" id="pendapatan-utama" class="dropdown w-full p-2 border border-gray-300 rounded">
                <option value="5">&gt;= 15.000.000 (5 = Sangat Penting)</option>
                <option value="4">10.000.000-14.999.999 (4 = Penting)</option>
                <option value="3">5.000.000-9.999.000 (3 = Cukup Penting)</option>
                <option value="2">1.500.000-4.999.000 (2 = Kurang Penting)</option>
                <option value="1">&lt;1.499.000 (1 = Sangat Kurang Penting)</option>
              </select>
            </div>
            <div class="form-group flex-1">
              <label for="pendapatan-lain" class="block text-gray-700 font mb-2">Pendapatan Lain</label>
              <select v-model="selectedPendapatanLain" id="pendapatan-lain" class="dropdown w-full p-2 border border-gray-300 rounded">
                <option value="5">&gt;= 15.000.000 (5 = Sangat Penting)</option>
                <option value="4">10.000.000-14.999.999 (4 = Penting)</option>
                <option value="3">5.000.000-9.999.000 (3 = Cukup Penting)</option>
                <option value="2">1.500.000-4.999.000 (2 = Kurang Penting)</option>
                <option value="1">&lt;1.499.000 (1 = Sangat Kurang Penting)</option>
              </select>
            </div>
          </div>
  
          <!-- Bobot Capital Form -->
          <h2 class="text-gray-800 font-semibold mb-4 mt-6">Form Bobot Capital</h2>
          <div class="flex gap-4">
            <div class="form-group flex-1">
              <label for="modal" class="block text-gray-700 font mb-2">Modal</label>
              <select v-model="selectedModal" id="modal" class="dropdown w-full p-2 border border-gray-300 rounded">
                <option value="5">&gt;= 100.000.000 (5 = Sangat Penting)</option>
                <option value="4">75.000.000-99.999.000 (4 = Penting)</option>
                <option value="3">50.000.000-74.999.000 (3 = Cukup Penting)</option>
                <option value="2">25.000.000-49.999.000 (2 = Kurang Penting)</option>
                <option value="1">&lt;24.999.000 (1 = Sangat Kurang Penting)</option>
              </select>
            </div>
            <div class="form-group flex-1">
              <label for="aset-selain-jaminan" class="block text-gray-700 font mb-2">Aset Selain Jaminan</label>
              <select v-model="selectedAsetSelainJaminan" id="aset-selain-jaminan" class="dropdown w-full p-2 border border-gray-300 rounded">
                <option value="5">&gt;= 100.000.000 (5 = Sangat Penting)</option>
                <option value="4">75.000.000-99.999.000 (4 = Penting)</option>
                <option value="3">50.000.000-74.999.000 (3 = Cukup Penting)</option>
                <option value="2">25.000.000-49.999.000 (2 = Kurang Penting)</option>
                <option value="1">&lt;24.999.000 (1 = Sangat Kurang Penting)</option>
              </select>
            </div>
          </div>
          <router-link to="/penilaian2" class="next-button mt-8 inline-block text-center">
          Next
        </router-link>
        </section>
      </main>
    </div>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';

  
  const searchQuery = ref('');
  const selectedOJK = ref('5'); 
  const selectedPendapatanUtama = ref('5');
  const selectedPendapatanLain = ref('5');
  const selectedModal = ref('5');
  const selectedAsetSelainJaminan = ref('5');
  const currentTab = ref('all');

  
  
  function setActiveMenu(menu) {
    activeMenu.value = menu;
  }
  
  function handleSearch() {}
  
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
  .dropdown {
    border: 1px solid #ddd;
    padding: 0.5rem;
    border-radius: 5px;
  }
  .next-button {
  background-color: #3b82f6;
  color: white;
  padding: 0.5rem 1.5rem;
  border-radius: 5px;
  font-weight: bold;
  transition: background-color 0.3s;
}

.next-button:hover {
  background-color: #2563eb;
}
  </style>
  