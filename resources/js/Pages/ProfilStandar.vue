<template>
  <div class="flex">
    <!-- Sidebar Component -->
    <Sidebar />

    <!-- Main Content -->
    <main class="flex-1 p-5 overflow-y-auto ml-16"> <!-- Reduced left margin here -->
      <header class="py-2">
        <div class="container mx-auto flex justify-between items-center">
          <h1 class="text-gray-800 font-bold text-lg">
            {{ activeMenu === 'profil standar' ? 'Profil Standar' : 'Menu Lainnya' }}
          </h1>
        </div>
      </header>

      <form @submit.prevent="submitForm" class="mt-4 grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
        <!-- Form Sections -->
        <div v-for="(item, index) in formItems" :key="index" class="form-section">
          <h2 class="text-gray-800 font-semibold mb-2">{{ item.label }}</h2>
          <select v-model="form[item.key]" :id="item.key" class="dropdown w-full p-2 border border-gray-300 rounded">
            <option v-for="(option, idx) in item.options" :key="idx" :value="option.value">
              {{ option.text }}
            </option>
          </select>
        </div>

        <!-- Submit Button -->
        <div class="col-span-full text-left">
          <button type="submit" class="next-button mt-6 inline-block text-center bg-red-500 text-white px-4 py-2 rounded">
            Update
          </button>
        </div>
      </form>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Sidebar from './Sidebar.vue'; // Import Sidebar component

// Sidebar State
const activeMenu = ref('profil standar');
const setActiveMenu = (menu) => {
  activeMenu.value = menu;
};

// Props from Controller
const props = defineProps(["profil_standar"]);

// Form Data (Set Defaults)
const form = ref({
  slik: props.profil_standar?.slik || "",
  pendapatan_utama: props.profil_standar?.pendapatan_utama || "",
  pendapatan_lain: props.profil_standar?.pendapatan_lain || "",
  modal: props.profil_standar?.modal || "",
  aset: props.profil_standar?.aset || "",
  tanggungan: props.profil_standar?.tanggungan || "",
  biaya_lain: props.profil_standar?.biaya_lain || "",
  bpkb: props.profil_standar?.bpkb || "",
  shm: props.profil_standar?.shm || "",
});

// Form Items
const formItems = [
  {
    label: 'SLIK OJK',
    key: 'slik',
    options: [
      { value: 5, text: 'SLIK OJK 1 (5 = Lancar)' },
      { value: 4, text: 'SLIK OJK 2 (4 = Dalam Perhatian Khusus)' },
      { value: 3, text: 'SLIK OJK 3 (3 = Kurang Lancar)' },
      { value: 2, text: 'SLIK OJK 4 (2 = Diragukan)' },
      { value: 1, text: 'SLIK OJK 5 (1 = Macet)' },
    ],
  },
  {
    label: 'Pendapatan Utama',
    key: 'pendapatan_utama',
    options: [
      { value: 5, text: '>= 15.000.000 (5 = Sangat Penting)' },
      { value: 4, text: '10.000.000 - 14.999.999 (4 = Penting)' },
      { value: 3, text: '5.000.000 - 9.999.999 (3 = Cukup Penting)' },
      { value: 2, text: '1.500.000 - 4.999.999 (2 = Kurang Penting)' },
      { value: 1, text: '< 1.499.999 (1 = Sangat Kurang Penting)' },
    ],
  },
  {
    label: 'Pendapatan Lain',
    key: 'pendapatan_lain',
    options: [
      { value: 5, text: '>= 15.000.000 (5 = Sangat Penting)' },
      { value: 4, text: '10.000.000 - 14.999.999 (4 = Penting)' },
      { value: 3, text: '5.000.000 - 9.999.999 (3 = Cukup Penting)' },
      { value: 2, text: '1.500.000 - 4.999.999 (2 = Kurang Penting)' },
      { value: 1, text: '< 1.499.999 (1 = Sangat Kurang Penting)' },
    ],
  },
  {
    label: 'Modal',
    key: 'modal',
    options: [
      { value: 5, text: '>= 100.000.000 (5 = Sangat Penting)' },
      { value: 4, text: '75.000.000 - 99.999.999 (4 = Penting)' },
      { value: 3, text: '50.000.000 - 74.999.999 (3 = Cukup Penting)' },
      { value: 2, text: '25.000.000 - 49.999.999 (2 = Kurang Penting)' },
      { value: 1, text: '< 24.999.999 (1 = Sangat Kurang Penting)' },
    ],
  },
  {
    label: 'Aset Selain Jaminan',
    key: 'aset',
    options: [
      { value: 5, text: '>= 100.000.000 (5 = Sangat Penting)' },
      { value: 4, text: '75.000.000 - 99.999.999 (4 = Penting)' },
      { value: 3, text: '50.000.000 - 74.999.999 (3 = Cukup Penting)' },
      { value: 2, text: '25.000.000 - 49.999.999 (2 = Kurang Penting)' },
      { value: 1, text: '< 24.999.999 (1 = Sangat Kurang Penting)' },
    ],
  },
  {
    label: 'Jumlah Tanggungan',
    key: 'tanggungan',
    options: [
      { value: 5, text: '0 - 1 (5 = Sangat Penting)' },
      { value: 4, text: '2 - 3 (4 = Penting)' },
      { value: 3, text: '4 - 5 (3 = Cukup Penting)' },
      { value: 2, text: '6 - 7 (2 = Kurang Penting)' },
      { value: 1, text: '> 7 (1 = Sangat Kurang Penting)' },
    ],
  },
  {
    label: 'Biaya Lain',
    key: 'biaya_lain',
    options: [
      { value: 5, text: '< 999.999 (5 = Sangat Penting)' },
      { value: 4, text: '1.000.000 - 1.999.999 (4 = Penting)' },
      { value: 3, text: '2.000.000 - 2.999.999 (3 = Cukup Penting)' },
      { value: 2, text: '3.000.000 - 3.999.999 (2 = Kurang Penting)' },
      { value: 1, text: '>= 4.000.000 (1 = Sangat Kurang Penting)' },
    ],
  },
  {
    label: 'BPKB',
    key: 'bpkb',
    options: [
      { value: 5, text: '>= 50.000.000 (5 = Sangat Penting)' },
      { value: 4, text: '25.000.000 - 49.999.999 (4 = Penting)' },
      { value: 3, text: '10.000.000 - 24.999.999 (3 = Cukup Penting)' },
      { value: 2, text: '5.000.000 - 9.999.999 (2 = Kurang Penting)' },
      { value: 1, text: '< 4.999.999 (1 = Sangat Kurang Penting)' },
    ],
  },
  {
    label: 'SHM',
    key: 'shm',
    options: [
      { value: 5, text: '>= 100.000.000 (5 = Sangat Penting)' },
      { value: 4, text: '50.000.000 - 99.999.999 (4 = Penting)' },
      { value: 3, text: '25.000.000 - 49.999.999 (3 = Cukup Penting)' },
      { value: 2, text: '10.000.000 - 24.999.999 (2 = Kurang Penting)' },
      { value: 1, text: '< 9.999.999 (1 = Sangat Kurang Penting)' },
    ],
  },
];

// Submit Form
const submitForm = () => {
  Inertia.put(route('profil-standar.update'), form.value);
};
</script>

<style scoped>
/* Custom Styles for Form Layout */
.form-section {
  padding: 1rem;
  border: 1px solid #e2e8f0;
  border-radius: 0.5rem;
  background-color: white;
}

.dropdown {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #e2e8f0;
  border-radius: 0.5rem;
  background-color: #fff;
}

.next-button {
  padding: 10px 20px;
  background-color: #ff3b3f;
  color: white;
  font-weight: bold;
  border-radius: 8px;
  cursor: pointer;
}

.next-button:hover {
  background-color: #f00;
}
</style>