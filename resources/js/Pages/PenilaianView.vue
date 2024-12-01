<template>
  <div class="flex overflow-hidden bg-white h-screen">
    <aside class="sidebar bg-gray-100 w-64">
      <div class="flex items-center gap-4 p-4 text-xs font-extrabold text-white bg-red-950 rounded-lg">
        <img src="../../../public/assets/Exclude.png" alt="Logo" class="object-contain w-[20px]" />
        <span>$IKEDEB</span>
      </div>
      <a href="#" class="sidebar-link" :class="{'active': activeMenu === 'profil standar'}" @click="setActiveMenu('profil standar')">
        <img src="../../../public/assets/IconPenilaian.png" alt="Penilaian Icon" class="icon" /> Profil Standar
      </a>
    </aside>

    <main class="flex-1 p-5 overflow-y-auto">
      <header class="py-2">
        <div class="container mx-auto flex justify-between items-center">
          <h1 class="text-gray-800 font-bold text-lg">{{ activeMenu === 'home' ? 'Home' : 'Profil Standar' }}</h1>
        </div>
      </header>

      <form @submit.prevent="updateProfilStandar">
      <section class="mt-4 grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
        <!-- Form Bobot Character -->
        <div class="form-section">
          <h2 class="text-gray-800 font-semibold mb-2">SLIK OJK</h2>
          <select v-model="form.slik" id="slik" class="dropdown w-full p-2 border border-gray-300 rounded">
            <option value="5">SLIK OJK 1 (5 = Lancar)</option>
            <option value="4">SLIK OJK 2 (4 = Dalam Perhatian Khusus)</option>
            <option value="3">SLIK OJK 3 (3 = Kurang Lancar)</option>
            <option value="2">SLIK OJK 4 (2 = Diragukan)</option>
            <option value="1">SLIK OJK 5 (1 = Macet)</option>
          </select>
        </div>

        <!-- Form Bobot Capacity -->
        <div class="form-section">
          <h2 class="text-gray-800 font-semibold mb-2">Pendapatan Utama</h2>
          <select v-model="form.pendapatan_utama" id="pendapatan_utama" class="dropdown w-full p-2 border border-gray-300 rounded">
            <option value="5">&gt;= 15.000.000 (5 = Sangat Penting)</option>
            <option value="4">10.000.000-14.999.999 (4 = Penting)</option>
            <option value="3">5.000.000-9.999.000 (3 = Cukup Penting)</option>
            <option value="2">1.500.000-4.999.000 (2 = Kurang Penting)</option>
            <option value="1">&lt;1.499.000 (1 = Sangat Kurang Penting)</option>
          </select>
        </div>

        <div class="form-section">
          <h2 class="text-gray-800 font-semibold mb-2">Pendapatan Lain</h2>
          <select v-model="form.pendapatan_lain" id="pendapatan_lain" class="dropdown w-full p-2 border border-gray-300 rounded">
            <option value="5">&gt;= 15.000.000 (5 = Sangat Penting)</option>
            <option value="4">10.000.000-14.999.999 (4 = Penting)</option>
            <option value="3">5.000.000-9.999.000 (3 = Cukup Penting)</option>
            <option value="2">1.500.000-4.999.000 (2 = Kurang Penting)</option>
            <option value="1">&lt;1.499.000 (1 = Sangat Kurang Penting)</option>
          </select>
        </div>

        <!-- Form Bobot Capital -->
        <div class="form-section">
          <h2 class="text-gray-800 font-semibold mb-2">Modal</h2>
          <select v-model="form.modal" id="modal" class="dropdown w-full p-2 border border-gray-300 rounded">
            <option value="5">&gt;= 100.000.000 (5 = Sangat Penting)</option>
            <option value="4">75.000.000-99.999.000 (4 = Penting)</option>
            <option value="3">50.000.000-74.999.000 (3 = Cukup Penting)</option>
            <option value="2">25.000.000-49.999.000 (2 = Kurang Penting)</option>
            <option value="1">&lt;24.999.000 (1 = Sangat Kurang Penting)</option>
          </select>
        </div>

        <div class="form-section">
          <h2 class="text-gray-800 font-semibold mb-2">Aset Selain Jaminan</h2>
          <select v-model="form.aset" id="aset" class="dropdown w-full p-2 border border-gray-300 rounded">
            <option value="5">&gt;= 100.000.000 (5 = Sangat Penting)</option>
            <option value="4">75.000.000-99.999.000 (4 = Penting)</option>
            <option value="3">50.000.000-74.999.000 (3 = Cukup Penting)</option>
            <option value="2">25.000.000-49.999.000 (2 = Kurang Penting)</option>
            <option value="1">&lt;24.999.000 (1 = Sangat Kurang Penting)</option>
          </select>
        </div>

        <!-- Form Bobot Condition -->
        <div class="form-section">
          <h2 class="text-gray-800 font-semibold mb-2">Jumlah Tanggungan</h2>
          <select v-model="form.tanggungan" id="tanggungan" class="dropdown w-full p-2 border border-gray-300 rounded">
            <option value="5">0 - 1 (5 = Sangat Penting)</option>
            <option value="4">2 - 3 (4 = Penting)</option>
            <option value="3">4 - 5 (3 = Cukup Penting)</option>
            <option value="2">6 - 7 (2 = Kurang Penting)</option>
            <option value="1">> 7 (1 = Sangat Kurang Penting)</option>
          </select>
        </div>

        <div class="form-section">
          <h2 class="text-gray-800 font-semibold mb-2">Biaya Lain</h2>
          <select v-model="form.biaya_lain" id="biaya_lain" class="dropdown w-full p-2 border border-gray-300 rounded">
            <option value="5">< 999.000 (5 = Sangat Penting)</option>
            <option value="4">1.000.000 - 1.999.000 (4 = Penting)</option>
            <option value="3">2.000.000 - 2.999.000 (3 = Cukup Penting)</option>
            <option value="2">3.000.000 - 3.999.000 (2 = Kurang Penting)</option>
            <option value="1">>= 4.000.000 (1 = Sangat Kurang Penting)</option>
          </select>
        </div>

        <!-- Form Bobot Collateral -->
        <div class="form-section">
          <h2 class="text-gray-800 font-semibold mb-2">BPKB</h2>
          <select v-model="form.bpkb" id="bpkb" class="dropdown w-full p-2 border border-gray-300 rounded">
            <option value="5">>= 50.000.000 (5 = Sangat Penting)</option>
            <option value="4">25.000.000 - 49.999.000 (4 = Penting)</option>
            <option value="3">15.000.000 - 24.999.000 (3 = Cukup Penting)</option>
            <option value="2">5.000.000 - 14.999.000 (2 = Kurang Penting)</option>
            <option value="1">< 4.999.000 (1 = Sangat Kurang Penting)</option>
          </select>
        </div>

        <div class="form-section">
          <h2 class="text-gray-800 font-semibold mb-2">SHM</h2>
          <select v-model="form.shm" id="shm" class="dropdown w-full p-2 border border-gray-300 rounded">
            <option value="5">>= 200.000.000 (5 = Sangat Penting)</option>
            <option value="4">150.000.000 - 199.999.000 (4 = Penting)</option>
            <option value="3">100.000.000 - 149.999.000 (3 = Cukup Penting)</option>
            <option value="2">50.000.000 - 99.999.000 (2 = Kurang Penting)</option>
            <option value="1">< 49.999.000 (1 = Sangat Kurang Penting)</option>
          </select>
        </div>

      </section>
      </form>

      <router-link to="" class="next-button mt-6 inline-block text-center">
        Update
      </router-link>
    </main>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
</script>

<script>

</script>

<style scoped>
.sidebar {
  padding: 1rem;
  height: 100vh;
}
.sidebar-link {
  display: flex;
  align-items: center;
  padding: 0.5rem;
  text-decoration: none;
  color: #333;
}
.form-section {
  background: #f9f9f9;
  padding: 1rem;
  border-radius: 0.5rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}
.dropdown {
  font-size: 0.875rem;
}
.next-button {
  background-color: #3b82f6;
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  font-weight: bold;
}
</style>
