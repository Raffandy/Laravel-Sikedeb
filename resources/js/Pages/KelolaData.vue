<template>
  <div class="flex overflow-hidden bg-white">
    <aside class="sidebar bg-gray-100 w-64 flex flex-col">
      <div class="flex items-center gap-4 p-4 text-xs font-extrabold text-white bg-red-950 rounded-lg">
        <img src="../../../public/assets/Exclude.png" alt="Logo" class="object-contain w-[20px]" />
        <span>$IKEDEB</span>
      </div>
      <a href="/dashboard/data" class="sidebar-link" :class="{'active': activeMenu === 'home'}" @click="setActiveMenu('home')">
        <img src="../../../public/assets/Vector.png" alt="Kelola Data Icon" class="icon" /> 
        Home
      </a>

      <div>
        <a href="#" class="sidebar-link" :class="{'active': activeMenu === 'kelola'}" @click="toggleKelolaMenu">
          <img src="../../../public/assets/Icon.png" alt="Kelola Data Icon" class="icon" /> 
          Kelola Data
        </a>
        <div v-if="isKelolaMenuOpen" class="submenu">
          <a href="#" class="sidebar-link" :class="{'active': activeDataMenu === 'personal'}" @click="setActiveDataMenu('personal')">
            Personal Details
          </a>
          <a href="#" class="sidebar-link" :class="{'active': activeDataMenu === 'applicant'}" @click="setActiveDataMenu('applicant')">
            Applicant Details
          </a>
          <a href="#" class="sidebar-link" :class="{'active': activeDataMenu === 'collateral'}" @click="setActiveDataMenu('collateral')">
            Collateral Details
          </a>
        </div>
      </div>
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

    <main class="flex-1 p-5">
      <header class="py-4">
        <!-- <div class="container mx-auto flex justify-between items-center px-9">
          <h1 class="text-gray-800 font-bold">{{ activeMenu === 'home' ? 'Home' : 'Kelola Data' }}</h1>
          <div class="flex items-center gap-2">
            <div class="relative">
              <input type="text" v-model="searchQuery" placeholder="Search..." class="search-input" />
              <button @click="handleSearch" class="search-button absolute inset-y-0 right-0 flex items-center pr-3">🔍</button>
            </div>
            <button @click="addNew" class="add-new-button">Add New</button>
          </div>
        </div> -->
      </header>

      <!-- User Profile Modal -->
      <div v-if="profileModalOpen" class="profile-modal fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg w-80 shadow-lg">
          <h2 class="text-xl font-bold mb-4">User Profile</h2>
          <p class="text-sm text-gray-600 mb-4">Name: {{ username }}</p>
          <button @click="Inertia.get(route('profile.edit'));" class="cancel-button mt-2 w-full bg-blue-300 text-black py-2 rounded">Profil</button>
          <button @click="Inertia.post(route('logout'));" class="logout-button mt-4 w-full bg-red-500 text-white py-2 rounded">Logout</button>
          <button @click="toggleProfileModal" class="cancel-button mt-2 w-full bg-gray-300 text-black py-2 rounded">Cancel</button>
        </div>
      </div>

      <!-- Personal Details Form -->
      <form v-if="activeDataMenu === 'personal'" class="personal-details-form mt-4" @submit.prevent="nextForm('personal')">
        <h2 class="text-lg font-bold mb-2">Personal Details</h2>
        <div class="flex flex-col space-y-2">
          <input type="text" v-model="personalDetails.nama" placeholder="Nama" class="form-input" required />
          <input type="text" v-model="personalDetails.nik" placeholder="NIK" class="form-input" required />
          <input type="text" v-model="personalDetails.alamat" placeholder="Alamat" class="form-input" required />
          <input type="text" v-model="personalDetails.pekerjaan" placeholder="Pekerjaan" class="form-input" required />
          <input type="text" v-model="personalDetails.jenis_usaha" placeholder="Jenis Usaha" class="form-input" required />
        </div>
        <button type="submit" class="next-button mt-4">Next</button>
      </form>

      <!-- Applicant Details Form -->
      <form v-if="activeDataMenu === 'applicant'" class="applicant-details-form mt-4" @submit.prevent="nextForm('applicant')">
        <h2 class="text-lg font-bold mb-2">Applicant Details</h2>
        <div class="flex flex-col space-y-2">
          <label for="penilaianSLIK" class="font-semibold">Penilaian SLIK OJK</label>
          <select id="penilaianSLIK" v-model="applicantDetails.slik" class="form-input" required>
            <option value="" disabled selected>Pilih Penilaian (1-5)</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
          <input type="number" v-model="applicantDetails.pendapatan_utama" placeholder="Pendapatan Utama" class="form-input" required />
          <input type="number" v-model="applicantDetails.pendapatan_lain" placeholder="Pendapatan Lain" class="form-input" required />
          <input type="number" v-model="applicantDetails.modal" placeholder="Modal" class="form-input" required />
          <input type="number" v-model="applicantDetails.aset" placeholder="Aset Selain Jaminan" class="form-input" required />
          <input type="number" v-model="applicantDetails.tanggungan" placeholder="Jumlah Tanggungan" class="form-input" required/>
          <input type="number" v-model="applicantDetails.biaya_lain" placeholder="Biaya Lain" class="form-input" required />
        </div>
        <button type="submit" class="next-button mt-4">Next</button>
      </form>

      <!-- Collateral Details Form -->
      <form v-if="activeDataMenu === 'collateral'" class="collateral-details-form mt-4" @submit.prevent="nextForm('collateral')">
        <h2 class="text-lg font-bold mb-2">Collateral Details</h2>
        <div class="flex flex-col space-y-2">
          <label for="jenisJaminan" class="font-semibold">Jenis Jaminan</label>
          <select id="jenisJaminan" v-model="collateralDetails.jenis_jaminan" class="form-input" required>
            <option value="" disabled selected>Pilih Jenis Jaminan</option>
            <option value="BPKB">BPKB</option>
            <option value="SHM">SHM</option>
          </select>
          <input type="number" v-model="collateralDetails.harga" placeholder="Harga" class="form-input" required />
        </div>
        <button type="submit" class="finish-button mt-4">Finish</button>
      </form>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const activeMenu = ref('kelola');
const activeDataMenu = ref('personal');
const searchQuery = ref('');
const isKelolaMenuOpen = ref(true);
const profileModalOpen = ref(false);

const personalDetails = ref({
  nama: '',
  nik: '',
  alamat: '',
  pekerjaan: '',
  jenis_usaha: '',
});

const applicantDetails = ref({
  slik: '',
  pendapatan_utama: '',
  pendapatan_lain: '',
  modal: '',
  aset: '',
  tanggungan: '',
  biaya_lain: '',
});

const collateralDetails = ref({
  jenis_jaminan: '',
  harga: '',
});

function nextForm(currentForm) {
  if (currentForm === 'personal') {
    activeDataMenu.value = 'applicant';
  } else if (currentForm === 'applicant') {
    activeDataMenu.value = 'collateral';
  } else if (currentForm === 'collateral') {
      const data = {
        ...personalDetails.value,
        ...applicantDetails.value,
        ...collateralDetails.value,
      };
      Inertia.post('/data/store', data, {
        onSuccess: () => alert('Data berhasil disimpan!'),
      });
  }
}

  // BATAS
function setActiveMenu(menu) {
  activeMenu.value = menu;
}

function toggleKelolaMenu() {
  isKelolaMenuOpen.value = !isKelolaMenuOpen.value;
}

function setActiveDataMenu(menu) {
  activeDataMenu.value = menu;
}

function handleSearch() {
  console.log('Search Query:', searchQuery.value);
}

function addNew() {
  Inertia.visit('/kelola');
}

function toggleProfileModal() {
  profileModalOpen.value = !profileModalOpen.value;
}
</script>

<script>
export default {
  props: {
    username: String,
    role: String,
  },
};
</script>

<style scoped>
/* Styling tetap sesuai instruksi */
.sidebar { padding: 1rem; height: 100vh; }
.sidebar-link { display: flex; align-items: center; padding: 1rem; color: #333; }
.sidebar-link.active { color: blue; }
.sidebar-link:hover { background-color: #f0f0f0; }
.icon { width: 20px; margin-right: 0.5rem; }
.submenu { padding-left: 1rem; }
.search-input { border: 1px solid #ddd; padding: 0.5rem; }
.search-button { background: none; border: none; cursor: pointer; }
.add-new-button { background-color: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 5px; cursor: pointer; }
.form-input { border: 1px solid #ddd; padding: 0.5rem; width: 100%; }
.next-button, .finish-button { background-color: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 5px; cursor: pointer; }
.text-gray-500 {
  color: #a0aec0; /* This is a gray color; adjust as needed */
}

</style>
