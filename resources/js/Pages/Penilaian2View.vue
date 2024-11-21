<template>
  <div class="flex overflow-hidden bg-white">
    <aside class="sidebar bg-gray-100 w-64">
      <div class="flex items-center gap-4 p-4 text-xs font-extrabold text-white bg-red-950 rounded-lg">
        <img src="../assets/Exclude.png" alt="Logo" class="object-contain w-[20px]" />
        <span>$IKEDEB</span>
      </div>
      <a href="#" class="sidebar-link" :class="{'active': activeMenu === 'penilaian kelayakan'}" @click="setActiveMenu('penilaian kelayakan')">
        <img src="../assets/IconPenilaian.png" alt="Penilaian Icon" class="icon" /> Penilaian Kelayakan
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
        <h2 class="text-gray-800 font-semibold mb-4 mt-6">Form Bobot Condition</h2>
        <div class="flex gap-4">
          <div class="form-group flex-1">
            <label for="jumlahtanggungan" class="block text-gray-700 font mb-2">Jumlah Tanggungan</label>
            <select v-model="selectedJumlahTanggungan" id="jumlahtanggungan" class="dropdown w-full p-2 border border-gray-300 rounded">
              <option value="5">0 - 1 (5 = Sangat Penting)</option>
              <option value="4">2 - 3 (4 = Penting)</option>
              <option value="3">4 - 5 (3 = Cukup Penting)</option>
              <option value="2">6 - 7 (2 = Kurang Penting)</option>
              <option value="1">> 7 (1 = Sangat Kurang Penting)</option>
            </select>
          </div>
          <div class="form-group flex-1">
            <label for="biayalain" class="block text-gray-700 font mb-2">Biaya Lain</label>
            <select v-model="selectedBiayaLain" id="biayalain" class="dropdown w-full p-2 border border-gray-300 rounded">
              <option value="5">< 999.000 (5 = Sangat Penting)</option>
              <option value="4">1.000.000 - 1.999.000 (4 = Penting)</option>
              <option value="3">2.000.000 - 2.999.000 (3 = Cukup Penting)</option>
              <option value="2">3.000.000 - 3.999.000 (2 = Kurang Penting)</option>
              <option value="1">>= 4.000.000 (1 = Sangat Kurang Penting)</option>
            </select>
          </div>
        </div>
      </section>

      <section class="mt-6"> <!-- Add margin-top for spacing -->
        <h2 class="text-gray-800 font-bold mb-4 mt-6">Form Bobot Collateral</h2> <!-- Made the header bold -->
        <div class="form-group flex-1">
          <label for="collateral" class="block text-gray-700 font mb-2">Pilih Collateral</label> <!-- Bold label -->
          <select v-model="selectedCollateral" id="collateral" class="dropdown w-full p-2 border border-gray-300 rounded">
            <option value="" disabled selected>Opsi Collateral</option>
            <option value="SHM">SHM</option>
            <option value="BPKB">BPKB</option>
          </select>
        </div>

        <!-- Conditional Dropdown for SHM -->
        <div v-if="selectedCollateral === 'SHM'" class="form-group flex-1">
          <label for="collateralSHM" class="block text-gray-700 font mb-2">Pilih Bobot SHM</label>
          <select v-model="selectedSHMValue" id="collateralSHM" class="dropdown w-full p-2 border border-gray-300 rounded">
            <option value="" disabled selected>Opsi Bobot SHM</option>
            <option value="5">>= 200.000.000 (5 = Sangat Penting)</option>
            <option value="4">150.000.000 - 199.999.000 (4 = Penting)</option>
            <option value="3">100.000.000 - 149.999.000 (3 = Cukup Penting)</option>
            <option value="2">50.000.000 - 99.999.000 (2 = Kurang Penting)</option>
            <option value="1">< 49.999.000 (1 = Sangat Kurang Penting)</option>
          </select>
        </div>

        <!-- Conditional Dropdown for BPKB -->
        <div v-if="selectedCollateral === 'BPKB'" class="form-group flex-1">
          <label for="collateralBPKB" class="block text-gray-700 font mb-2">Pilih Bobot BPKB</label>
          <select v-model="selectedBPKBValue" id="collateralBPKB" class="dropdown w-full p-2 border border-gray-300 rounded">
            <option value="" disabled selected>Opsi Bobot BPKB</option>
            <option value="5">>= 50.000.000 (5 = Sangat Penting)</option>
            <option value="4">25.000.000 - 49.999.000 (4 = Penting)</option>
            <option value="3">15.000.000 - 24.999.000 (3 = Cukup Penting)</option>
            <option value="2">5.000.000 - 14.999.000 (2 = Kurang Penting)</option>
            <option value="1">< 4.999.000 (1 = Sangat Kurang Penting)</option>
          </select>
        </div>
        <router-link to="/HasilPenilaian" class="submit-button mt-8 inline-block text-center">
          Submit
        </router-link>
      </section>
    </main>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';

const searchQuery = ref('');
const activeMenu = ref('Hasil Penilaian');
const currentTab = ref('all');
const selectedJumlahTanggungan = ref('5');
const selectedBiayaLain = ref('5');
const selectedCollateral = ref('');
const selectedSHMValue = ref('');
const selectedBPKBValue = ref('');
const router = useRouter();

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
.submit-button {
  background-color: #4CBB17;
  color: white;
  padding: 0.5rem 1.5rem;
  border-radius: 5px;
  font-weight: bold;
  transition: background-color 0.3s;
}

.submit-button:hover {
  background-color: #4CBB17;
}
</style>
